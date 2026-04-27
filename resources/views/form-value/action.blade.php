@can('download-submitted-form')
    <a href="{{ route('download.form.values.pdf', $formValue->id) }}" class="btn btn-success btn-sm"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Download') }}"><i
            class="ti ti-file-download"></i></a>
@endcan
@can('show-submitted-form')
    <a href="{{ route('formvalues.show', $formValue->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('View') }}"><i class="ti ti-eye"></i>
        </span></a>
@endcan
@can('edit-submitted-form')
    <a href="{{ route('formvalues.edit', $formValue->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}"><i class="ti ti-edit"></i>
    </a>
@endcan
@can('delete-submitted-form')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['formvalues.destroy', $formValue->id],
        'id' => 'delete-form-' . $formValue->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-danger btn-sm show_confirm" id="delete-form-{{ $formValue->id }}"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Delete') }}"><i
            class="mr-0 ti ti-trash"></i></a>
    {!! Form::close() !!}
@endcan
