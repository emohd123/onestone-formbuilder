<?php

namespace App\Http\Controllers;

use App\DataTables\PlanDataTable;
use App\Facades\UtilityFacades;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index(PlanDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-plan')) {
            if (Auth::user()->type == 'Super Admin') {
                return $dataTable->render('plans.index');
            } else {
                $plans = Plan::where('active_status', 1)->get();

                $user  = User::where('id', Auth::user()->id)->first();
                return view('plans.index', compact('user', 'plans'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create-plan')) {
            return view('plans.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-plan')) {
            $request->validate([
                'name'          => 'required|max:191|unique:plans,name',
                'price'         => 'required|numeric',
                'duration'      => 'required|numeric',
                'durationtype'  => 'required|string|max:191',
                'max_users'     => 'integer|nullable',
                'max_roles'     => 'integer|nullable',
                'max_form'      => 'required|integer',
                'max_booking'   => 'integer|nullable',
                'max_documents' => 'integer|nullable',
                'max_polls'     => 'integer|nullable',
                'description1'  => 'max:255|nullable',
                'description2'  => 'max:255|nullable',
                'description3'  => 'max:255|nullable',
                'description4'  => 'max:255|nullable',
                'description5'  => 'max:255|nullable',
                'description6'  => 'max:255|nullable',
                'description7'  => 'max:255|nullable',
                'description8'  => 'max:255|nullable',
            ]);

            Plan::create([
                'name'          => $request->name,
                'price'         => $request->price,
                'duration'      => $request->duration,
                'durationtype'  => $request->durationtype,
                'max_users'     => $request->max_users ?? 0,
                'max_roles'     => $request->max_roles ?? 0,
                'max_form'      => $request->max_form,
                'max_booking'   => $request->max_booking ?? 0,
                'max_documents' => $request->max_documents ?? 0,
                'max_polls'     => $request->max_polls ?? 0,
                'description1'  => $request->description1,
                'description2'  => $request->description2,
                'description3'  => $request->description3,
                'description4'  => $request->description4,
                'description5'  => $request->description5,
                'description6'  => $request->description6,
                'description7'  => $request->description7,
                'description8'  => $request->description8,
            ]);

            return redirect()->route('plans.index')
                ->with('success', __('Plan created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('edit-plan')) {
            $plan = Plan::find($id);
            return view('plans.edit', compact('plan'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-plan')) {
            $request->validate([
                'name'          => 'required|max:191|unique:plans,name,' . $id,
                'price'         => 'required|numeric',
                'duration'      => 'required|numeric',
                'durationtype'  => 'required|string|max:191',
                'max_users'     => 'integer|nullable',
                'max_roles'     => 'integer|nullable',
                'max_form'      => 'required|integer',
                'max_booking'   => 'integer|nullable',
                'max_documents' => 'integer|nullable',
                'max_polls'     => 'integer|nullable',
                'description1'  => 'max:255|nullable',
                'description2'  => 'max:255|nullable',
                'description3'  => 'max:255|nullable',
                'description4'  => 'max:255|nullable',
                'description5'  => 'max:255|nullable',
                'description6'  => 'max:255|nullable',
                'description7'  => 'max:255|nullable',
                'description8'  => 'max:255|nullable',
            ]);

            $plan = Plan::findOrFail($id);
            $plan->update([
                'name'          => $request->name,
                'price'         => $request->price,
                'duration'      => $request->duration,
                'durationtype'  => $request->durationtype,
                'max_users'     => $request->max_users ?? 0,
                'max_roles'     => $request->max_roles ?? 0,
                'max_form'      => $request->max_form,
                'max_booking'   => $request->max_booking ?? 0,
                'max_documents' => $request->max_documents ?? 0,
                'max_polls'     => $request->max_polls ?? 0,
                'description1'  => $request->description1,
                'description2'  => $request->description2,
                'description3'  => $request->description3,
                'description4'  => $request->description4,
                'description5'  => $request->description5,
                'description6'  => $request->description6,
                'description7'  => $request->description7,
                'description8'  => $request->description8,
            ]);

            return redirect()->route('plans.index')
                ->with('success', __('Plan updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete-plan')) {
            $plan = Plan::find($id);
            if ($plan->id != 1) {
                $planExistInOrder = Order::where('plan_id', $plan->id)->first();
                if (empty($planExistInOrder)) {
                    $plan->delete();
                    return redirect()->route('plans.index')->with('success', __('Plan deleted successfully.'));
                } else {
                    return redirect()->back()->with('failed', __('Can not delete this plan because its purchased by users.'));
                }
            } else {
                return redirect()->back()->with('failed', __('Can not delete this plan because its free plan.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function planStatus($id, Request $request)
    {
        $plan = Plan::find($id);
        $input = ($request->value == "true") ? 1 : 0;
        if ($plan) {
            $plan->active_status = $input;
            $plan->save();
        }
        return response()->json(['is_success' => true, 'message' => __('Plan status changed successfully.')]);
    }

    public function payment($code)
    {
        $planId                 = \Illuminate\Support\Facades\Crypt::decrypt($code);
        $plan                   = Plan::find($planId);
        $paymentTypes           = UtilityFacades::getpaymenttypes();
        $adminPaymentSetting    = UtilityFacades::getAdminPaymentSettings();
        if ($plan) {
            return view('plans.payment', compact('plan', 'adminPaymentSetting', 'paymentTypes'));
        } else {
            return redirect()->back()->with('errors', __('Plan deleted successfully.'));
        }
    }
}
