<?php
namespace App\DataTables;

use Auth;
use Carbon\Carbon;
use App\Models\Form;
use App\Models\User;
use App\Models\FormValue;
use Illuminate\Http\Request;
use App\Facades\UtilityFacades;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FormValuesDataTable extends DataTable
{
    public function dataTable($query)
    {
        $formValueData = datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function (FormValue $formValue) {
                return '<input type="checkbox" name="row_checkbox[]" class="row_checkbox" value="' . $formValue->id . '">';
            })
            ->editColumn('amount', function (FormValue $formValue) {
                return $formValue->currency_symbol . $formValue->amount;
            })
            ->editColumn('status', function (FormValue $formValue) {
                if ($formValue->status == "free") {
                    $status = '<span class="p-2 px-3 badge rounded-pill bg-primary">' . __('Free') . '</span>';
                    return $status;
                } else if ($formValue->status == "pending") {
                    $status = '<span class="p-2 px-3 badge rounded-pill bg-warning">' . __('Pending') . '</span>';
                    return $status;
                } else if ($formValue->status == "successfull") {
                    $status = '<span class="p-2 px-3 badge rounded-pill bg-success">' . __('Successfull') . '</span>';
                    return $status;
                } else {
                    $status = '<span class="p-2 px-3 badge rounded-pill bg-danger">' . __('Failed') . '</span>';
                    return $status;
                }
            })
            ->editColumn('created_at', function (FormValue $formValue) {
                return $formValue->created_at;
            })
            // ->editColumn('user', function (FormValue $formValue) {
            //     $userName   =  User::where('id', $formValue->user_id)->first();
            //     $user       = ($formValue->user_id) ? $userName->name : 'Guest';
            //     return $user;
            // })
            ->addColumn('user', function (FormValue $formValue) {
                return optional($formValue->User)->name;
            })
            ->editColumn('user', function (FormValue $formValue) {
                if ($formValue->User && !empty($formValue->User->name)) {
                    return $formValue->User->name;
                }

                $decodedJson = json_decode($formValue->json, true);
                if (!is_array($decodedJson) || !isset($decodedJson[0]) || !is_array($decodedJson[0])) {
                    return 'Guest';
                }

                $acceptedLabels = [
                    'Name',
                    'First Name',
                    'First &amp; Last Name',
                    'First & Last Name',
                    'Full Name',
                    'Applicant Name',
                    'Contact Name',
                ];

                foreach ($decodedJson[0] as $field) {
                    if (!is_array($field)) {
                        continue;
                    }

                    $label = $field['label'] ?? '';
                    if (
                        isset($field['value']) &&
                        $field['value'] !== '' &&
                        $label !== '' &&
                        in_array($label, $acceptedLabels, true)
                    ) {
                        return $field['value'];
                    }
                }

                return 'Guest';
            })
            ->addColumn('action', function (FormValue $formValue) {
                return view('form-value.action', compact('formValue'));
            });

        $labels = $this->labels();
        if ($labels != null) {
            foreach ($labels as $key => $label) {
                $formValueData->editColumn($key, function (FormValue $formValue) use ($key) {
                    $jsonData   = $formValue->json;
                    $jsonArray  = json_decode($jsonData, true);
                    $value      = "-";
                    foreach ($jsonArray as $items) {
                        foreach ($items as $item) {
                            if (isset($item['show_datatable']) && $item['show_datatable']) {
                                if ($item['name'] === $key) {
                                    if ($item['type'] === 'starRating') {
                                        $value = '';
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($item['value'] < $i) {
                                                if (is_float($item['value']) && (round($item['value']) == $i)) {
                                                    $value .= '<i class="text-warning fas fa-star-half-alt"></i>';
                                                } else {
                                                    $value  .= '<i class="fas fa-star"></i>';
                                                }
                                            } else {
                                                $value      .= '<i class="text-warning fas fa-star"></i>';
                                            }
                                        }
                                    } elseif ($item['type'] === 'radio-group' || $item['type'] === 'select' || $item['type'] === 'checkbox-group') {
                                        $selectedValues     = [];
                                        foreach ($item['values'] as $option) {
                                            if (isset($option['selected']) && $option['selected'] == 1) {
                                                $selectedValues[] = $option['label'];
                                            }
                                        }
                                        $value = implode(', ', $selectedValues);
                                    } elseif ($item['type'] === 'date') {
                                        $value                  = '';
                                        if ($item['value']) {
                                            $date               = Carbon::createFromFormat('Y-m-d', $item['value']);
                                            $formattedDate      = $date->format('jS M Y');
                                            $value              = $formattedDate;
                                        }
                                    } else {
                                        $value                  = $item['value'];
                                    }
                                }
                            }
                        }
                    }
                    return $value;
                });
            }
            $arr = array_merge(['checkbox', 'status', 'action', 'user', 'type', 'created_at'], array_keys($labels));
        } else {
            $arr = array_merge(['checkbox', 'status', 'action', 'user', 'type', 'created_at']);
        }
        $formValueData->rawColumns($arr);
        return $formValueData;
    }

    public function query(FormValue $model, Request $request)
    {
        $usr = Auth::user();
        $roleId = $usr->roles->first()->id;
        $userId = $usr->id;
        if ($usr->type != 'Admin') {
            $formValues =  $model->newQuery()
                ->select(['form_values.*', 'forms.title'])
                ->join('forms', 'forms.id', 'form_values.form_id')
                ->where(function ($query1) use ($roleId, $userId) {
                    $query1->whereIn('form_values.form_id', function ($query) use ($roleId) {
                        $query->select('form_id')->from('assign_forms_roles')->where('role_id', $roleId);
                    })
                        ->orWhereIn('form_values.form_id', function ($query) use ($userId) {
                            $query->select('form_id')->from('assign_forms_users')->where('user_id', $userId);
                        })
                        ->OrWhere('assign_type', 'public');
                });
        } else {
            $formValues = FormValue::select(['form_values.*', 'forms.title'])
                ->join('forms', 'forms.id', 'form_values.form_id')
                ->leftJoin('users', 'users.id', 'form_values.user_id');
        }
        if ($request->start_date && $request->end_date) {
            $formValues->whereBetween('form_values.created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->form) {
            $formValues->where('form_values.form_id', $request->form);
        }
        if ($request->user_name) {
            $formValues = FormValue::select(['form_values.*', 'users.name as usr_name'])
                ->join('users', 'users.id', 'form_values.user_id');
            $formValues->where('users.name', 'LIKE', '%' . $request->user_name . '%')->Where('form_values.form_id', $request->form);
        }

        return $formValues;
    }

    public function labels()
    {
        $recordId       = $this->form_id;
        $formValue      = Form::find($recordId);
        if ($formValue->json != '') {
            $jsonData   = $formValue->json;
            $jsonArray  = json_decode($jsonData, true);
            $filteredData = [];
            foreach ($jsonArray as $jArray) {
                foreach ($jArray as $item) {
                    if (isset($item['show_datatable']) && $item['show_datatable'] == true) {
                        $filteredData[$item['name']] =  $item['label'];
                    }
                }
            }
            $label = $filteredData;
            return $label;
        }
    }

//     public function html()
//     {
//         $pdfButton     = [];
//         if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
//             $pdfButton = ["extend" => "pdf", "text" => '<i class="fas fa-file-pdf"></i>' . __('PDF'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]];
//         }
//         return $this->builder()
//             ->setTableId('forms-table')
//             ->addIndex()
//             ->columns($this->getColumns($this->labels()))
//             ->ajax([
//                 'data' => 'function(d) {
//                             var filter = $(".created_at").val();
//                             var spilit = filter.split("to");
//                             d.form = $("#form_id").val();
//                             d.start_date = spilit[0];
//                             d.end_date = spilit[1];

//                             var user_filter = $("input[name=user]").val();
//                             d.user_name = user_filter;
//                         }'
//             ])
//             ->orderBy(1)
//             ->language([
//                 "paginate" => [
//                     "next" => '<i class="ti ti-chevron-right"></i>',
//                     "previous" => '<i class="ti ti-chevron-left"></i>'
//                 ],
//                 'lengthMenu' => __("_MENU_") . __('Entries Per Page'),
//                 "searchPlaceholder" => __('Search...'), "search" => "",
//                 "info" => __('Showing _START_ to _END_ of _TOTAL_ entries')

//             ])
//             ->initComplete('function() {
//                 var table = this;
//                 $("body").on("click", ".add_filter", function() {
//                     $("#forms-table").DataTable().draw();
//                 });
//                 $("body").on("click", ".clear_filter", function() {
//                     $(".created_at").val("");
//                     $("input[name=user]").val("");
//                     $("#forms-table").DataTable().draw();
//                 });
//                 var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
//                 searchInput.removeClass(\'form-control form-control-sm\');
//                 searchInput.addClass(\'dataTable-input\');
//                 var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');

//                 // Handle select all checkbox
//                 $(\'#select-all\').on(\'click\', function(){
//                     var rows = table.api().rows({ \'search\': \'applied\' }).nodes();
//                     $(\'input[type="checkbox"]\', rows).prop(\'checked\', this.checked);
//                 });

//                 $(\'#forms-table tbody\').on(\'change\', \'input[type="checkbox"]\', function(){
//                     if(!this.checked){
//                       var el = $(\'#select-all\').get(0);
//                       if(el && el.checked && (el.indeterminate === false)){
//                           el.indeterminate = true;
//                       }
//                     }
//                 });
//             }')
//             ->parameters([
//                 "dom" =>  "
//                 <'dataTable-top row'<'dataTable-dropdown page-dropdown col-lg-2 col-sm-12'l><'dataTable-botton table-btn col-lg-6 col-sm-12'B>>
//                 <'dataTable-container'<'col-sm-12'tr>>
//                 <'dataTable-bottom row'<'col-sm-5'i><'col-sm-7'p>>
//                 ",
//                 'buttons'   => [
// //                    [
// //                        'extend' => 'collection', 'className' => 'w-inherit btn btn-light-secondary me-1 dropdown-toggle', 'text' => '<i class="ti ti-download"></i> ' . __('Export'), "buttons" => [
// //                            ["extend" => "print", "text" => '<i class="fas fa-print"></i> ' . __('Print'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
// //                            ["extend" => "csv", "text" => '<i class="fas fa-file-csv"></i> ' . __('CSV'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
// //                            ["extend" => "excel", "text" => '<i class="fas fa-file-excel"></i> ' . __('Excel'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
// //                            $pdfButton
// //                        ],
// //                    ],
// //                    ['extend' => 'reset', 'className' => 'w-inherit btn btn-light-danger me-1'],
// //                    ['extend' => 'reload', 'className' => 'w-inherit btn btn-light-warning'],
//                 ],
//                 "drawCallback" => 'function( settings ) {
//                     var tooltipTriggerList = [].slice.call(
//                         document.querySelectorAll("[data-bs-toggle=tooltip]")
//                       );
//                       var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
//                         return new bootstrap.Tooltip(tooltipTriggerEl);
//                       });
//                       var popoverTriggerList = [].slice.call(
//                         document.querySelectorAll("[data-bs-toggle=popover]")
//                       );
//                       var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
//                         return new bootstrap.Popover(popoverTriggerEl);
//                       });
//                       var toastElList = [].slice.call(document.querySelectorAll(".toast"));
//                       var toastList = toastElList.map(function (toastEl) {
//                         return new bootstrap.Toast(toastEl);
//                       });
//                 }',
//             ])->language([
//                 'buttons' => [
//                     'create' => __('Create'),
//                     'export' => __('Export'),
//                     'print' => __('Print'),
//                     'reset' => __('Reset'),
//                     'reload' => __('Reload'),
//                     'excel' => __('Excel'),
//                     'csv' => __('CSV'),
//                 ]
//             ]);
//     }


    public function html()
    {
        $pdfButton = [];
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
            $pdfButton = [
                "extend" => "pdf",
                "text" => '<i class="fas fa-file-pdf"></i>' . __('PDF'),
                "className" => "btn btn-light text-primary dropdown-item",
                "exportOptions" => ["columns" => [0, 1, 3]]
            ];
        }

        return $this->builder()
            ->setTableId('forms-table')
            ->addIndex()
            ->columns($this->getColumns($this->labels()))
            ->ajax([
                'data' => 'function(d) {
                var filter = $(".created_at").val();
                var spilit = filter.split("to");
                d.form = $("#form_id").val();
                d.start_date = spilit[0];
                d.end_date = spilit[1];
                var user_filter = $("input[name=user]").val();
                d.user_name = user_filter;
            }'
            ])
            ->orderBy(1)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>',
                    "previous" => '<i class="ti ti-chevron-left"></i>'
                ],
                'lengthMenu' => __("_MENU_") . __('Entries Per Page'),
                "searchPlaceholder" => __('Search...'),
                "search" => "",
                "info" => __('Showing _START_ to _END_ of _TOTAL_ entries')
            ])
            ->initComplete('function() {
                var table = this;
                $("body").on("click", ".add_filter", function() {
                    $("#forms-table").DataTable().draw();
                });
                $("body").on("click", ".clear_filter", function() {
                    $(".created_at").val("");
                    $("input[name=user]").val("");
                    $("#forms-table").DataTable().draw();
                });
                var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
                searchInput.removeClass(\'form-control form-control-sm\');
                searchInput.addClass(\'dataTable-input\');
                var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');

                // Handle select all checkbox
                $(\'#select-all\').on(\'click\', function(){
                    var isChecked = this.checked;
                    if(isChecked && confirm(\'Are you sure you want to select all items?\')){
                        var rows = table.api().rows({ \'search\': \'applied\' }).nodes();
                        $(\'input[type="checkbox"]\', rows).prop(\'checked\', isChecked);

                        $(\'#delete-button\').removeClass(\'d-none\');
                    } else {
                        this.checked = false;
                        $(\'input[type="checkbox"]\', table.api().rows({ \'search\': \'applied\' }).nodes()).prop(\'checked\', false);
                        $(\'#delete-button\').addClass(\'d-none\');
                    }
                });

                // Handle select all checkbox
                $(\'.row_checkbox\').on(\'click\', function(){
                    var checkedCheckboxes = $(\'#forms-table tbody input[type="checkbox"]:checked\').length;
                    if(checkedCheckboxes <= 0){
                        $(\'#delete-button\').addClass(\'d-none\');
                    } else {
                        $(\'#delete-button\').removeClass(\'d-none\');
                    }
                });
            }')
            ->parameters([
                "dom" => "
            <'dataTable-top row'<'dataTable-dropdown page-dropdown col-lg-2 col-sm-12'l>
            <'dataTable-botton table-btn col-lg-6 col-sm-12'B>>
            <'dataTable-container'<'col-sm-12'tr>>
            <'dataTable-bottom row'<'col-sm-5'i><'col-sm-7'p>>
            ",
                'buttons' => [],
                "drawCallback" => 'function( settings ) {
                    var tooltipTriggerList = [].slice.call(
                       document.querySelectorAll("[data-bs-toggle=tooltip]")
                      );
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                      return new bootstrap.Tooltip(tooltipTriggerEl);
                       });
                   var popoverTriggerList = [].slice.call(
                       document.querySelectorAll("[data-bs-toggle=popover]")
                   );
                    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                      return new bootstrap.Popover(popoverTriggerEl);
                     });
                    var toastElList = [].slice.call(document.querySelectorAll(".toast"));
                    var toastList = toastElList.map(function (toastEl) {
                     return new bootstrap.Toast(toastEl);
                    });
           }',
            ])->language([
                'buttons' => [
                    'create' => __('Create'),
                    'export' => __('Export'),
                    'print' => __('Print'),
                    'reset' => __('Reset'),
                    'reload' => __('Reload'),
                    'excel' => __('Excel'),
                    'csv' => __('CSV'),
                ]
            ]);
    }

    protected function getColumns($label)
    {
        $columns = [
            Column::computed('checkbox')
                ->title('<input type="checkbox" id="select-all">')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false),
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('user')->title(__('User')),
            Column::make('created_at')->title(__('Date')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->addClass('text-end')
        ];

        return $columns;
    }

    protected function filename(): string
    {
        return 'FormValues_' . date('YmdHis');
    }
}
