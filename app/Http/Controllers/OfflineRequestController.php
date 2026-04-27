<?php

namespace App\Http\Controllers;

use App\DataTables\OfflineRequestDataTable;
use App\Facades\UtilityFacades;
use App\Mail\ApproveOfflineMail;
use App\Mail\OfflineMail;
use App\Models\Coupon;
use App\Models\OfflineRequest;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\MailTemplates\Models\MailTemplate;

class OfflineRequestController extends Controller
{
    public function index(OfflineRequestDataTable $dataTable)
    {
        return $dataTable->render('offline-request.index');
    }

    public function offlineRequestStatus($id)
    {

        $offline            = OfflineRequest::find($id);
        $user               = User::find($offline->user_id);
        $plan               = Plan::find($offline->plan_id);
        $order              = Order::find($offline->order_id);
        $coupons            = Coupon::find($offline->coupon_id);
        $user->plan_id      = $plan->id;
        if (!empty($coupons)) {
            $userCoupon         = new UserCoupon();
            $userCoupon->user   = $user->id;
            $userCoupon->coupon = $coupons->id;
            $userCoupon->order  = $order->id;
            $userCoupon->save();
            $usedCoupun = $coupons->usedCoupon();
            if ($coupons->limit <= $usedCoupun) {
                $coupons->is_active = 0;
                $coupons->save();
            }
        }
        if ($plan->durationtype == 'Month' && $plan->id != '1') {
            $user->plan_expired_date = Carbon::now()->addMonths($plan->duration)->isoFormat('YYYY-MM-DD');
        } elseif ($plan->durationtype == 'Year' && $plan->id != '1') {
            $user->plan_expired_date = Carbon::now()->addYears($plan->duration)->isoFormat('YYYY-MM-DD');
        } else {
            $user->plan_expired_date = null;
        }
        $user->save();
        $offline->is_approved   = 1;
        $offline->update();
        $order->status          = 1;
        $order->paymet_type     = 'offline';
        $order->update();
        $user = User::find($offline->user_id);
        if (UtilityFacades::getsettings('email_setting_enbale') == 'on') {
            if (MailTemplate::where('mailable', ApproveOfflineMail::class)->first()) {
                try {
                    Mail::to($offline->email)->send(new ApproveOfflineMail($plan, $user));
                } catch (\Exception $e) {
                    return redirect()->back()->with('errors', $e->getMessage());
                }
            }
        }
        return redirect()->back()->with('success',  __('Plan update request send successfully.'));
    }

    public function offlineDisapprove(Request $request, $id)
    {
        request()->validate([
            'disapprove_reason'             => 'required|string',
        ]);
        $offlineRequest                     = OfflineRequest::find($id);
        $offlineRequest->disapprove_reason  = $request->disapprove_reason;
        $offlineRequest->is_approved        = 2;
        $offlineRequest->update();
        $order                              = Order::find($offlineRequest->order_id);
        $order->status                      = 2;
        $order->paymet_type                 = 'offline';
        $order->update();
        $user                               = User::find($offlineRequest->user_id);
        if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
            if (MailTemplate::where('mailable', OfflineMail::class)->first()) {
                try {
                    Mail::to($offlineRequest->email)->send(new OfflineMail($offlineRequest, $user));
                } catch (\Exception $e) {
                    return redirect()->back()->with('errors', $e->getMessage());
                }
            }
        }
        return redirect()->back()->with('success', __('Request disapprove successfully.'));
    }

    public function disapproveStatus($id)
    {
        $offlineRequest   = OfflineRequest::find($id);
        if ($offlineRequest->is_approved == 0) {
            $view         = view('offline-request.reason', compact('offlineRequest'));
            return ['html' => $view->render()];
        } else {
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $offlineRequest = OfflineRequest::find($id);
        $offlineRequest->delete();
        return redirect()->back()->with('success', __('Offline request deleted successfully.'));
    }
    public function freeTrial(Request $request){
        if (Auth::user()->type == 'Admin') {
            $authuser = \Auth::user();
            $planID = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
            $plan = Plan::find($planID);
            $user = Auth::user();
            $user->plan_id = $planID;
            $user->plan_expired_date = Carbon::now()->addMonths($plan->duration)->toDateTimeString();


            $user->update();

            return redirect()->route('home')->with('success', __('Free Trial Start Successfully.'));
        }
    }

    //offline coupon
    public function offlinePaymentEntry(Request $request)
    {
        if (Auth::user()->type == 'Admin') {
            $authuser           = \Auth::user();
            $planID             = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
            $plan               = Plan::find($planID);
            $couponId           = '0';
            $couponCode         = null;
            $discountValue      = null;
            $price              = $plan->price;
            $coupons            = Coupon::where('code', $request->coupon)->where('is_active', '1')->first();
            if ($coupons) {
                $couponCode     = $coupons->code;
                $usedCoupun     = $coupons->usedCoupon();
                if ($coupons->limit == $usedCoupun) {
                    $res_data['errors'] = 'This coupon code has expired.';
                } else {
                    $discount = $coupons->discount;
                    $discount_type  = $coupons->discount_type;
                    $discountValue  = UtilityFacades::calculateDiscount($price, $discount, $discount_type);
                    $price          = $price - $discountValue;
                    if ($price < 0) {
                        $price      = $plan->price;
                    }
                    $couponId       = $coupons->id;
                }
            }
            $order = Order::create([
                'plan_id'           => $plan->id,
                'user_id'           => $authuser->id,
                'amount'            => $price,
                'discount_amount'   => $discountValue,
                'coupon_code'       => $couponCode,
                'status'            => 0,
                'paymet_type'            => 'online',
            ]);



            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.tap.company/v2/charges/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'amount' => $price,
                    'currency' => 'BHD',
                    'customer_initiated' => true,
                    'threeDSecure' => true,
                    'save_card' => true,
                    'description' => 'Plan name: '.$plan->name,
                    'metadata' => [
                        'udf1' => 'Metadata 1'
                    ],
                    'reference' => [
                        'transaction' => 'txn_' . date('Ymd_His') . '_' . uniqid(),
                        'order' => $order->id,
                    ],
                    'receipt' => [
                        'email' => true,
                        'sms' => true
                    ],
                    'customer' => [
                        'first_name' => $authuser->name,
                        'email' => $authuser->email,
                        'phone' => [
                            'country_code' => $authuser->country_code,
                            'number' => $authuser->phone,
                        ]
                    ],
                    'merchant' => [
                        'id' => '21601227'
                    ],
                    'source' => [
                        'id' => 'src_all'
                    ],
                    'post' => [
//                        'url' => 'http://127.0.0.1:8000/offlinepayment'
                        'url' => 'https://app.onestoneads.com/offlinepayment'
                    ],
                    'redirect' => [
//                        'url' => 'http://127.0.0.1:8000/callbackpayment'
                        'url' => 'https://app.onestoneads.com/callbackpayment'
                    ]
                ]),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer sk_live_dbLr2VIkFlXfST5eysw6uZmR",
                    "accept: application/json",
                    "content-type: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            // Assuming $response is a JSON string
            $responseData = json_decode($response);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                return redirect()->to($responseData->transaction->url);
            }

        } else {
            OfflineRequest::create([
                'order_id'      => $request->o_order_id,
                'plan_id'       => $request->o_plan_id,
                'user_id'       =>  Auth::user()->id,
                'email'         => Auth::user()->email,
            ]);
        }
        return redirect()->route('plans.index')
            ->with('success',  __('Plan update request send successfully.'));
    }
    public function payment_callback(Request $request){
        $input = $request->all();


        $curl = curl_init();


        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.tap.company/v2/charges/".$input['tap_id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
            "Authorization: Bearer sk_live_dbLr2VIkFlXfST5eysw6uZmR",
            "accept: application/json",
            "content-type: application/json"
        ],
        ]);
        $output = curl_exec($curl);
        $err = curl_error($curl);

        // Assuming $response is a JSON string
        $outputData  = json_decode($output);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

           if ($outputData->status == 'CAPTURED'){
               $order_id = $outputData->reference->order;
               $order = Order::where('id' , $order_id)->first();
//               dd($outputData);
               $order->payment_id = $outputData->reference->transaction;
               $order->chr_id = $outputData->id;
               $order->status = 1;
            //   $order->paymet_type = $outputData->card->brand . ' ' .  $outputData->card->first_six . 'xxxxxx'.  $outputData->card->last_four;

               $order->update();
               $user = Auth::user('id');

               $plan               = Plan::find($order->plan_id);
               if ($plan->durationtype == 'Month' && $plan->id != '1') {
                   $user->plan_expired_date = Carbon::now()->addMonths($plan->duration)->isoFormat('YYYY-MM-DD');
               } elseif ($plan->durationtype == 'Year' && $plan->id != '1') {
                   $user->plan_expired_date = Carbon::now()->addYears($plan->duration)->isoFormat('YYYY-MM-DD');
               } else {
                   $user->plan_expired_date = null;
               }
               $user->plan_id = $order->plan_id;
               

               $user->update();
               return redirect()->route('home')->with('status', 'Thanks for upgrade your plan, now you can create your form.');
           }
           else{
               return redirect()->route('plans.index')->with('status', 'There is a problem with your payment, please try again!');
           }
        }



    }
}
