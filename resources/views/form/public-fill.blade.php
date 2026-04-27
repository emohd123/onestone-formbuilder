@extends('layouts.form')
@section('title', __('Fill'))
@section('background_image', $backgroundImage)
@section('content')


    @if (session()->has('success'))

        <div class="card">
            <div class="card-header">
                <h5 class="text-center w-100">Enter your details to receive the PDF copy of your Submitted Form.</h5>
            </div>
            <div class="card-body">

                <form action="{{route('forms.customer.store' , ['id' => $form->id])}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="demo@demo.com" >
                    </div>

                    <div style="display: flex; align-items: center;">
                        <select id="country_code" name="country_code" class="form-control"   style="max-width: 80px;">
                            <!-- Country code options here -->
                            <option data-countryCode="BH" value="973">BH (+973)</option>
                            <option data-countryCode="SA" value="966">SA (+966)</option>
                            <option data-countryCode="PK" value="92">PK (+92)</option>
                            <!-- Add more country codes as needed -->
                        </select>
                        <input type="tel" id="whatsapp_number" name="whatsapp_number" class="form-control" placeholder="545xxxx" pattern="[0-9]{9,11}" >
                    </div>
                    <br><br>

                    <button type="submit" id="continueBtn" class="btn btn-primary" disabled>Continue</button>
                    <a type="submit" class="btn btn-primary text-white">Skip</a>
                </form>
            </div>
        </div>
    @endif
    <div class="p-0 main-content">
        <section class="section">
            @include('form.public-multi-form')
        </section>
    </div>
@endsection
@push('style')
    <link href="{{ asset('assets/jqueryform/css/jquery.rateyo.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/formTheme/form.css') }}">
    <style>
        .bg-back {
            background-image: url({{ Storage::url($form->theme_background_image) }}) !important;
            background-size: cover !important;
            background-repeat: no-repeat !important;
        }

        .section-body.newform-2 {
            background-image: url({{ Storage::url($form->theme_background_image) }});
        }

        .bg-back .section-body.newform-2 {
            background-image: unset;
            background-size: unset;
            background-repeat: unset;
        }

        .tab {
            display: none;
        }

        #prevBtn {
            background-color: #bbbbbb;
        }

        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        .step.finish {
            background-color: #394EEA;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

    </style>
@endpush
@push('script')
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>
    <script src="{{ asset('vendor/js/jquery.payment.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>

    @if (Utility::getsettings('PAYTM_ENVIRONMENT') == 'production')
        <script type="application/javascript" crossorigin="anonymous" src="https:\\securegw.paytm.in\merchantpgpui\checkoutjs\merchants\{{ Utility::getsettings('PAYTM_MERCHANT_ID') }}.js" ></script>
    @else
        <script type="application/javascript" crossorigin="anonymous" src="https:\\securegw-stage.paytm.in\merchantpgpui\checkoutjs\merchants\{{ Utility::getsettings('PAYTM_MERCHANT_ID') }}.js" ></script>
    @endif

    @if ($form->payment_status == 1)
        @if ($form->payment_type == 'razorpay')
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        @elseif($form->payment_type == 'paypal')
            <script
                src="https://www.paypal.com/sdk/js?client-id={{ Utility::getsettings('PAYPAL_SANDBOX_CLIENT_ID') }}&currency={{ $form->currency_name }}">
            </script>
        @elseif($form->payment_type == 'flutterwave')
            <script src="https://checkout.flutterwave.com/v3.js"></script>
        @elseif($form->payment_type == 'paystack')
            <script src="https://js.paystack.co/v1/inline.js"></script>
        @endif
    @endif
    <script>
        $(document).ready(function() {
            var theme = '{{ $form->theme }}';
            var themeColor = '{{ $form->theme_color }}';
            $('body').removeClass();
            $('body').addClass(themeColor);
            if (theme === 'theme2') {
                $('.section-body').addClass('newform-1');
            } else if (theme === 'theme3') {
                $('body').addClass('bg-back');
                $('.section-body').addClass('newform-2');
            } else if (theme === 'theme4') {
                $('.section-body').addClass('newform-3');
            } else if (theme === 'theme5') {
                $('.section-body').addClass('newform-3 circle');
            } else if (theme === 'theme6') {
                $('.section-body').addClass('newform-3 circle-custom');
            } else if (theme === 'theme7') {
                $('.section-body').addClass('newform-1 newform-4');
            } else if (theme === 'theme8') {
                $('.section-body').addClass('newform-5');
            }
        });
        var form_value_id = $('#form_value_id').val();
        var SITEURL = '{{ URL::to('') }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        ('restrictNumeric');
        $('.cc-number').payment('formatCardNumber');
        $('.cc-exp').payment('formatCardExpiry');
        $('.cc-cvc').payment('formatCardCVC');
        $.fn.toggleInputError = function(erred) {
            this.parent('.form-group').toggleClass('has-error', erred);
            return this;
        };
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab
        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                $('.cap').show();
                $('.strip').show();
                $('.razorpay').show();
                $('.paypal').show();
                $('.paytm').show();
                $('.flutterwave').show();
                $('.paystack').show();
                $('payumoney').show();
                $('.coingate').show();
                $('.mercado').show();
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                $('.cap').hide();
                $('.strip').hide();
                $('.razorpay').hide();
                $('.paypal').hide();
                $('.paytm').hide();
                $('.flutterwave').hide();
                $('.paystack').hide();
                $('.payumoney').hide();
                $('.coingate').hide();
                $('.mercado').hide();
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            $('.step-' + currentTab).find('.tel').each(function() {
                if ($(this).attr('type') == 'tel') {
                    var tel = $(this).val();
                    var filter = /^\d*(?:\.\d{1,2})?$/;
                    if (filter.test(tel)) {
                        valid = true;
                    } else {
                        valid = false;
                        $(this).addClass('is-invalid');
                        return false;
                    }
                }
            });
            $('.step-' + currentTab).find('.email').each(function() {
                if ($(this).attr('type') == 'email') {
                    var emailStr = $(this).val();
                    var regex = /^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i;
                    if (regex.test(emailStr)) {
                        valid = true;
                    } else {
                        $(this).addClass('is-invalid');
                        valid = false;
                        return false;
                    }
                }
            });
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is is-invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            $('.tab').hide();
            // x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                var formData = new FormData($('#fill-form')[0]);
                var $this = $("#nextBtn");
                // var loadingText = '<i class="fa fa-spinner fa-spin"></i> Submiting form';
                // if ($("#nextBtn").html() !== loadingText) {
                //     $this.data('original-text', $("#nextBtn").html());
                //     $this.html(loadingText);
                // }
                @if ($form->payment_type == 'paypal')
                if ($('#payment_id').val() == '') {
                    var errorElement = document.getElementById('paypal-errors');
                    iziToast.error({
                        title: 'Error!',
                        message: "{{ 'Please make payment' }}",
                        position: 'topRight'
                    });
                    $('#nextBtn').removeAttr('disabled');
                    $('#nextBtn').html('Submit')
                    showTab(n);
                    return false;
                }
                @endif
                make_payment();
                setLoading(false);
                // $("#fill-form").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            var check = [];
            $('.step-' + currentTab).find('.required').each(function() {
                var name = $(this).attr('name');
                if ($(this).val() == "") {
                    $(this).addClass('is-invalid');
                    check.push(false);
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    check.push(true);
                }
                if ($(this).attr('type') == 'hidden') {
                    if ($(this).parents('.signature-pad-body').length) {
                        if ($(this).val() == "") {
                            $(this).parents('.signature-pad-body').find('.signaturePad').addClass('is-invalid');
                            $(this).parents('.signature-pad-body').find('.signaturePad').removeClass('is-valid');
                            showToStr('Error!', '{{ __('Please save your signature.') }}', 'danger',
                                '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                            check.push(false);
                        } else {
                            $(this).parents('.signature-pad-body').find('.signaturePad').addClass('is-valid');
                            $(this).parents('.signature-pad-body').find('.signaturePad').removeClass('is-invalid');
                            check.push(true);
                        }
                    }
                    if ($(this).parents('.cam-buttons').length) {
                        var videoContainer = $(this).parents('.cam-buttons');
                        var videoCam = videoContainer.find('.video_cam');
                        if (videoContainer.find('input[name="media"]').val() == "") {
                            videoCam.addClass('is-invalid');
                            videoCam.removeClass('is-valid');
                            showToStr('Error!', '{{ __('Video recording field is required.') }}', 'danger',
                                '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                            check.push(false);
                        } else {
                            videoCam.addClass('is-valid');
                            videoCam.removeClass('is-invalid');
                            check.push(true);
                        }
                    }
                    if ($(this).parents('.selfie_screen').length) {
                        var videoContainer = $(this).parents('.selfie_screen');
                        var videoCam = videoContainer.find('.selfie_photo');
                        if (videoContainer.find('input[name="image"]').val() == "") {
                            videoCam.addClass('is-invalid');
                            videoCam.removeClass('is-valid');
                            showToStr('Error!', '{{ __('This selfie field is required.') }}', 'danger',
                                '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                            check.push(false);
                        } else {
                            videoCam.addClass('is-valid');
                            videoCam.removeClass('is-invalid');
                            check.push(true);
                        }
                    }
                }
                if ($(this).attr('type') == 'email') {
                    var emailStr = $(this).val();
                    var regex = /^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i;
                    if (regex.test(emailStr)) {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        check.push(true);
                    } else {
                        $(this).addClass('is-invalid');
                        check.push(false);
                    }
                }
                if ($(this).attr('type') == 'tel') {
                    var tel = $(this).val();
                    var filter = /^\d*(?:\.\d{1,2})?$/;
                    if (filter.test(tel)) {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        check.push(true);
                    } else {
                        $(this).addClass('invalid');
                        check.push(false);
                    }
                }
                if ($(this).attr('type') == 'radio') {
                    if ($('input[name="' + name + '"]:checked').length <= 0) {
                        $(this).addClass('is-invalid');
                        $('.required-radio').html('Select any one');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $('.required-radio').html('');
                        check.push(true);
                    }
                }
                if ($(this).attr('type') == 'checkbox') {
                    if ($('input[name="' + name + '"]:checked').length <= 0) {
                        $(this).addClass('is-invalid');
                        $('.required-checkbox').html('Select any one');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $('.required-checkbox').html('');
                        check.push(true);
                    }
                }
                if ($(this).attr('type') == 'number') {
                    var numval = parseInt($(this).val());
                    var min = parseInt($(this).attr('min'));
                    var max = parseInt($(this).attr('max'));
                    if ($(this).val() == "") {
                        $(this).addClass('is-invalid');
                        $(this).next().html('Please fill in this field.');
                        $(this).removeClass('is-valid');
                        check.push(false);
                    } else {
                        if (isNaN(min) == false && isNaN(max) == true && min > numval) {
                            $(this).addClass('is-invalid')
                            $(this).parent().find('.required-number').html('Sorry minimum number is ' + min + '.');
                            $(this).removeClass('is-valid');
                            check.push(false);
                        } else if (isNaN(min) == true && isNaN(max) == false && max < numval) {
                            $(this).addClass('is-invalid')
                            $(this).parent().find('.required-number').html('Sorry maximum number is ' + max + '.');
                            $(this).removeClass('is-valid');
                            check.push(false);
                        } else if (isNaN(min) == false && isNaN(max) == false && (min > numval || numval > max)) {
                            $(this).addClass('is-invalid')
                            $(this).parent().find('.required-number').html('Select between minimum number ' + min +
                                ' and maximum number ' + max + '.');
                            $(this).removeClass('is-valid');
                            check.push(false);
                        } else {
                            $(this).removeClass('is-invalid');
                            $(this).addClass('is-valid');
                            $(this).parent().find('.required-number').html('');
                            check.push(true);
                        }
                    }
                }
                if ($(this).attr('type') == 'file') {
                    var inp = $(this).val();
                    if (inp.length == 0) {
                        $(this).addClass('is-invalid');
                        $(this).next().html('Please select file in this field.');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $(this).next().html('');
                        check.push(true);
                    }
                }
                if ($(this).attr('type') == 'date') {
                    var inp = $(this).val();
                    if (inp.length == 0) {
                        $(this).addClass('is-invalid');
                        $(this).next().html('Please select date in this field.');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $(this).next().html('');
                        check.push(true);
                    }
                }
                if ($(this)[0].localName == 'textarea') {
                    var inp = $(this).val();
                    if (inp.length == 0) {
                        $(this).addClass('is-invalid');
                        $(this).next().html('Please fill in this field.');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $(this).next().html('');
                        check.push(true);
                    }
                }
                if ($(this).attr('type') == 'text') {
                    var inp = $(this).val();
                    if (inp.length == 0) {
                        $(this).addClass('is-invalid');
                        $(this).next().html('Please fill in this field.');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $(this).next().html('');
                        check.push(true);
                    }
                }
            });
            var valid = true;
            check.forEach(function(val) {
                if (val == false) {
                    valid = false;
                    return false;
                }
            });
            if (valid) {
                $('.step-' + currentTab).addClass('finish');
            }
            return valid; // return the valid status
        }

        function make_payment() {
            var formData = new FormData($('#fill-form')[0]);
            if (form_value_id == '') {
                @if ($form->payment_status == 1)
                @if ($form->payment_type == 'stripe')
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        formData.append('stripeToken', result.token.id);
                    }
                }).then(function() {
                    submitForm(formData);
                });
                @elseif ($form->payment_type == 'paytm')
                var amount = '{{ $form->amount }}';
                var name = '{{ $form->title }}';
                var currency = '{{ $form->currency_name }}';
                var form_id = '{{ $form->id }}';
                var email = '{{ $form->email }}';
                var succes_msg = '{{ $form->success_msg }}';
                $.ajax({
                    type: 'POST',
                    url: "{{ route('paymentpaytm.payment') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'amount': amount,
                        'name': name,
                        'email': email,
                        'mobile': '123456789',
                        'succes_msg': succes_msg,
                        'form_id': form_id,
                    },
                    success: function(data) {
                        $('.paytm-pg-loader').show();
                        $('.paytm-overlay').show();

                        if (data.txnToken == "") {
                            showToStr('Failed!', data.message, 'danger',
                                '{{ asset('assets/images/notification/high_priority-48.png') }}',
                                4000);
                            $('.paytm-pg-loader').hide();
                            $('.paytm-overlay').hide();
                            return false;
                        }
                        invokeBlinkCheckoutPopup(data.orderId, data.txnToken, data.amount)
                    }
                });

                function invokeBlinkCheckoutPopup(orderId, txnToken, amount) {
                    window.Paytm.CheckoutJS.init({
                        "root": "",
                        "flow": "DEFAULT",
                        "data": {
                            "orderId": orderId,
                            "token": txnToken,
                            "tokenType": "TXN_TOKEN",
                            "amount": amount,
                        },
                        handler: {
                            transactionStatus: function(data) {},
                            notifyMerchant: function notifyMerchant(eventName, data) {
                                if (eventName == "APP_CLOSED") {
                                    $('.paytm-pg-loader').hide();
                                    $('.paytm-overlay').hide();
                                }
                            }
                        }
                    }).then(function() {
                        window.Paytm.CheckoutJS.invoke();
                        formData.append('payment_id', orderId);
                        submitForm(formData);
                    });
                }
                @elseif ($form->payment_type == 'flutterwave')
                var amount = '{{ $form->amount }}';
                var name = '{{ $form->title }}';
                var email = '{{ $form->email }}';
                var currency = '{{ $form->currency_name }}';
                var form_id = '{{ $form->id }}';
                var plan_name = '{{ $plans->name }}';
                const modal = FlutterwaveCheckout({
                    public_key: "{{ Utility::getsettings('FLW_PUBLIC_KEY') }}",
                    tx_ref: "titanic-48981487343MDI0NzMx",
                    amount: amount,
                    currency: currency,
                    payment_options: "card, banktransfer, ussd",
                    callback: function(payment) {
                        // Send AJAX verification request to backend
                        formData.append('payment_id', payment.transaction_id);
                        modal.close();
                        submitForm(formData);
                    },
                    onclose: function(incomplete) {
                        modal.close();
                        showToStr('Failed!', 'Transaction was not completed, window closed.',
                            'danger',
                            '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                    },
                    meta: {
                        consumer_id: form_id,
                        consumer_mac: "92a3-912ba-1192a",
                    },
                    customer: {
                        email: email,
                        phone_number: "08102909304",
                        name: name,
                    },
                    customizations: {
                        title: plan_name,
                        description: "Payment for an awesome cruise",
                        logo: "https://www.logolynx.com/images/logolynx/22/2239ca38f5505fbfce7e55bbc0604386.jpeg",
                    },
                });
                @elseif ($form->payment_type == 'paystack')
                var amount = '{{ $form->amount }}';
                var name = '{{ $form->title }}';
                var email = '{{ $form->email }}';
                var currency = '{{ $form->currency_name }}';
                var form_id = '{{ $form->id }}';
                var handler = PaystackPop.setup({
                    key: "{{ Utility::getsettings('PAYSTACK_PUBLIC_KEY') }}", // Replace with your public key
                    email: email,
                    amount: (amount *
                        100
                    ), // the amount value is multiplied by 100 to convert to the lowest currency unit
                    currency: currency, // Use GHS for Ghana Cedis or USD for US Dollars
                    ref: '{{ Str::random(10) }}', // Replace with a reference you generated
                    callback: function(response) {
                        //this happens after the payment is completed successfully
                        formData.append('payment_id', response.transaction);
                        var reference = response.reference;
                        showToStr('Done!', 'Payment complete! Reference: ' + reference, 'success',
                            '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
                        submitForm(formData);
                    },
                    onClose: function() {
                        showToStr('Failed!', 'Transaction was not completed, window closed.',
                            'danger',
                            '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                    },
                });
                handler.openIframe();
                @elseif ($form->payment_type == 'coingate')
                var amount = '{{ $form->amount }}';
                var currency = '{{ $form->currency_name }}';
                var form_id = '{{ $form->id }}';
                var created_by = '{{ $form->created_by }}';
                $('#cg_currency').val(currency);
                $('#cg_amount').val(amount);
                $('#cg_form_id').val(form_id);
                $('#cg_created_by').val(created_by);
                $('#coingate_payment_frms').submit();
                submitForm(formData);
                @elseif ($form->payment_type == 'mercado')
                var amount = '{{ $form->amount }}';
                var currency = '{{ $form->currency_name }}';
                var form_id = '{{ $form->id }}';
                var created_by = '{{ $form->created_by }}';
                $('#mercado_currency').val(currency);
                $('#mercado_amount').val(amount);
                $('#mercado_form_id').val(form_id);
                $('#mercado_created_by').val(created_by);
                $('#mercado_payment_frms').submit();
                submitForm(formData);
                @elseif ($form->payment_type == 'razorpay')
                var amount = '{{ $form->amount }}';
                var name = '{{ $form->title }}';
                var currency = '{{ $form->currency_name }}';
                var form_id = '{{ $form->id }}';
                var data = {
                    "_token": "{{ csrf_token() }}",
                    'price': amount,
                    'name': name,
                    'currency': currency,
                    'form_id': form_id,
                }
                var options = {
                    "key": "{{ Utility::getsettings('RAZORPAY_KEY') }}",
                    "amount": (amount * 100),
                    "name": name,
                    'currency': currency,
                    "description": "",
                    "image": '',
                    "handler": function(response) {
                        formData.append('payment_id', response.razorpay_payment_id);
                        submitForm(formData);
                        '{{ Crypt::encrypt(['payment_id' => ',response.razorpay_payment_id,', 'plan_id' => 'plan_id', 'request_user_id' => 'user_id', 'order_id' => 'order_id', 'type' => 'razorpay']) }}';
                        // window.location.href = SITEURL + '/' + 'pre-payment-success/' + data;
                    },
                    "theme": {
                        "color": "#528FF0"
                    }
                };
                // setLoading(true);
                var rzp1 = new Razorpay(options);
                rzp1.open();
                // e.preventDefault();
                @else
                submitForm(formData);
                @endif
                @else
                submitForm(formData);
                @endif
            } else {
                submitForm(formData);
            }
        }
        // Add the new code to handle the button click

        {{--function submitForm(formData) {--}}
        {{--    formData.append('ajax', true);--}}
        {{--    $.ajax({--}}
        {{--        type: "POST",--}}
        {{--        url: '{{ route('forms.fill.store', $form->id) }}',--}}
        {{--        data: formData,--}}
        {{--        processData: false,--}}
        {{--        contentType: false,--}}
        {{--        success: function(response) {--}}
        {{--            if (response.is_success) {--}}
        {{--                $('.form-card-body').html(--}}
        {{--                    '<div class="text-center gallery" id="success_loader"> <img src="{{ asset('assets/images/success.gif') }}" class="" /><br><br><h2 class="w-100 ">' +--}}
        {{--                    response.message + '</h2></div>');--}}
        {{--                $('#nextBtn').removeAttr('disabled');--}}
        {{--                $('#nextBtn').html(' Submit');--}}
        {{--            } else {--}}
        {{--                showToStr('Error!', response.message, 'danger');--}}
        {{--                $('#nextBtn').removeAttr('disabled');--}}
        {{--                $('#nextBtn').html('Submit');--}}
        {{--                var tabno = $('.tab').length - 1;--}}
        {{--                showTab(tabno);--}}
        {{--            }--}}
        {{--        },--}}
        {{--        error: function(error) {}--}}
        {{--    });--}}
        {{--}--}}

        function submitForm(formData) {
            $('#nextBtn').prop('disabled', true);
            $('#nextBtn').html('Submitting...');
            formData.append('ajax', true);
            $.ajax({
                type: "POST",
                url: '{{ route('forms.fill.store', $form->id) }}',
                data: formData,
                processData: false,
                contentType: false,
                timeout: 60000,
                success: function(response) {
                    if (response.is_success) {
                        var pdfUrl = response.pdfUrl;
                        // Display success message and form
                        $('.form-card-body').html(`
                        <h2 class="w-100"><h5 class="text-center w-100">Enter your details to receive the PDF copy of your Submitted Form.</h5>
</h2>
                        <form action="{{ route('forms.customer.store', ['id' => $form->id]) }}" method="POST" id="customerForm">
            @csrf
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="demo@demo.com" style="max-width: 245px">
                        </div>
                        <div style="display: flex; align-items: center;">
                            <select id="country_code" name="country_code" class="form-control" style="max-width: 120px;">
                                <!-- Country code options here -->
                                <option data-countryCode="BH" value="973">BH (+973)</option>
                               <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                                <optgroup label="Other countries">
                                    <option data-countryCode="DZ" value="213">Algeria (+213)</option>
                                    <option data-countryCode="AD" value="376">Andorra (+376)</option>
                                    <option data-countryCode="AO" value="244">Angola (+244)</option>
                                    <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                                    <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                                    <option data-countryCode="AR" value="54">Argentina (+54)</option>
                                    <option data-countryCode="AM" value="374">Armenia (+374)</option>
                                    <option data-countryCode="AW" value="297">Aruba (+297)</option>
                                    <option data-countryCode="AU" value="61">Australia (+61)</option>
                                    <option data-countryCode="AT" value="43">Austria (+43)</option>
                                    <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
                                    <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                                    <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                                    <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                                    <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                                    <option data-countryCode="BY" value="375">Belarus (+375)</option>
                                    <option data-countryCode="BE" value="32">Belgium (+32)</option>
                                    <option data-countryCode="BZ" value="501">Belize (+501)</option>
                                    <option data-countryCode="BJ" value="229">Benin (+229)</option>
                                    <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
                                    <option data-countryCode="BT" value="975">Bhutan (+975)</option>
                                    <option data-countryCode="BO" value="591">Bolivia (+591)</option>
                                    <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
                                    <option data-countryCode="BW" value="267">Botswana (+267)</option>
                                    <option data-countryCode="BR" value="55">Brazil (+55)</option>
                                    <option data-countryCode="BN" value="673">Brunei (+673)</option>
                                    <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
                                    <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                                    <option data-countryCode="BI" value="257">Burundi (+257)</option>
                                    <option data-countryCode="KH" value="855">Cambodia (+855)</option>
                                    <option data-countryCode="CM" value="237">Cameroon (+237)</option>
                                    <option data-countryCode="CA" value="1">Canada (+1)</option>
                                    <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
                                    <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
                                    <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
                                    <option data-countryCode="CL" value="56">Chile (+56)</option>
                                    <option data-countryCode="CN" value="86">China (+86)</option>
                                    <option data-countryCode="CO" value="57">Colombia (+57)</option>
                                    <option data-countryCode="KM" value="269">Comoros (+269)</option>
                                    <option data-countryCode="CG" value="242">Congo (+242)</option>
                                    <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
                                    <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                                    <option data-countryCode="HR" value="385">Croatia (+385)</option>
                                    <option data-countryCode="CU" value="53">Cuba (+53)</option>
                                    <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
                                    <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
                                    <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
                                    <option data-countryCode="DK" value="45">Denmark (+45)</option>
                                    <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                                    <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                                    <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                                    <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                                    <option data-countryCode="EG" value="20">Egypt (+20)</option>
                                    <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                                    <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
                                    <option data-countryCode="ER" value="291">Eritrea (+291)</option>
                                    <option data-countryCode="EE" value="372">Estonia (+372)</option>
                                    <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
                                    <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
                                    <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
                                    <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                                    <option data-countryCode="FI" value="358">Finland (+358)</option>
                                    <option data-countryCode="FR" value="33">France (+33)</option>
                                    <option data-countryCode="GF" value="594">French Guiana (+594)</option>
                                    <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
                                    <option data-countryCode="GA" value="241">Gabon (+241)</option>
                                    <option data-countryCode="GM" value="220">Gambia (+220)</option>
                                    <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
                                    <option data-countryCode="DE" value="49">Germany (+49)</option>
                                    <option data-countryCode="GH" value="233">Ghana (+233)</option>
                                    <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                                    <option data-countryCode="GR" value="30">Greece (+30)</option>
                                    <option data-countryCode="GL" value="299">Greenland (+299)</option>
                                    <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
                                    <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
                                    <option data-countryCode="GU" value="671">Guam (+671)</option>
                                    <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                                    <option data-countryCode="GN" value="224">Guinea (+224)</option>
                                    <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
                                    <option data-countryCode="GY" value="592">Guyana (+592)</option>
                                    <option data-countryCode="HT" value="509">Haiti (+509)</option>
                                    <option data-countryCode="HN" value="504">Honduras (+504)</option>
                                    <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                                    <option data-countryCode="HU" value="36">Hungary (+36)</option>
                                    <option data-countryCode="IS" value="354">Iceland (+354)</option>
                                    <option data-countryCode="IN" value="91">India (+91)</option>
                                    <option data-countryCode="ID" value="62">Indonesia (+62)</option>
                                    <option data-countryCode="IR" value="98">Iran (+98)</option>
                                    <option data-countryCode="IQ" value="964">Iraq (+964)</option>
                                    <option data-countryCode="IE" value="353">Ireland (+353)</option>
                                    <option data-countryCode="IL" value="972">Israel (+972)</option>
                                    <option data-countryCode="IT" value="39">Italy (+39)</option>
                                    <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                                    <option data-countryCode="JP" value="81">Japan (+81)</option>
                                    <option data-countryCode="JO" value="962">Jordan (+962)</option>
                                    <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
                                    <option data-countryCode="KE" value="254">Kenya (+254)</option>
                                    <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                                    <option data-countryCode="KP" value="850">Korea North (+850)</option>
                                    <option data-countryCode="KR" value="82">Korea South (+82)</option>
                                    <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                                    <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
                                    <option data-countryCode="LA" value="856">Laos (+856)</option>
                                    <option data-countryCode="LV" value="371">Latvia (+371)</option>
                                    <option data-countryCode="LB" value="961">Lebanon (+961)</option>
                                    <option data-countryCode="LS" value="266">Lesotho (+266)</option>
                                    <option data-countryCode="LR" value="231">Liberia (+231)</option>
                                    <option data-countryCode="LY" value="218">Libya (+218)</option>
                                    <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                                    <option data-countryCode="LT" value="370">Lithuania (+370)</option>
                                    <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                                    <option data-countryCode="MO" value="853">Macao (+853)</option>
                                    <option data-countryCode="MK" value="389">Macedonia (+389)</option>
                                    <option data-countryCode="MG" value="261">Madagascar (+261)</option>
                                    <option data-countryCode="MW" value="265">Malawi (+265)</option>
                                    <option data-countryCode="MY" value="60">Malaysia (+60)</option>
                                    <option data-countryCode="MV" value="960">Maldives (+960)</option>
                                    <option data-countryCode="ML" value="223">Mali (+223)</option>
                                    <option data-countryCode="MT" value="356">Malta (+356)</option>
                                    <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
                                    <option data-countryCode="MQ" value="596">Martinique (+596)</option>
                                    <option data-countryCode="MR" value="222">Mauritania (+222)</option>
                                    <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                                    <option data-countryCode="MX" value="52">Mexico (+52)</option>
                                    <option data-countryCode="FM" value="691">Micronesia (+691)</option>
                                    <option data-countryCode="MD" value="373">Moldova (+373)</option>
                                    <option data-countryCode="MC" value="377">Monaco (+377)</option>
                                    <option data-countryCode="MN" value="976">Mongolia (+976)</option>
                                    <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                                    <option data-countryCode="MA" value="212">Morocco (+212)</option>
                                    <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
                                    <option data-countryCode="MN" value="95">Myanmar (+95)</option>
                                    <option data-countryCode="NA" value="264">Namibia (+264)</option>
                                    <option data-countryCode="NR" value="674">Nauru (+674)</option>
                                    <option data-countryCode="NP" value="977">Nepal (+977)</option>
                                    <option data-countryCode="NL" value="31">Netherlands (+31)</option>
                                    <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
                                    <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
                                    <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
                                    <option data-countryCode="NE" value="227">Niger (+227)</option>
                                    <option data-countryCode="NG" value="234">Nigeria (+234)</option>
                                    <option data-countryCode="NU" value="683">Niue (+683)</option>
                                    <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
                                    <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
                                    <option data-countryCode="NO" value="47">Norway (+47)</option>
                                    <option data-countryCode="OM" value="968">Oman (+968)</option>
                                    <option data-countryCode="PK" value="92">Pakistan (+92)</option>
                                    <option data-countryCode="PW" value="680">Palau (+680)</option>
                                    <option data-countryCode="PA" value="507">Panama (+507)</option>
                                    <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
                                    <option data-countryCode="PY" value="595">Paraguay (+595)</option>
                                    <option data-countryCode="PE" value="51">Peru (+51)</option>
                                    <option data-countryCode="PH" value="63">Philippines (+63)</option>
                                    <option data-countryCode="PL" value="48">Poland (+48)</option>
                                    <option data-countryCode="PT" value="351">Portugal (+351)</option>
                                    <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
                                    <option data-countryCode="QA" value="974">Qatar (+974)</option>
                                    <option data-countryCode="RE" value="262">Reunion (+262)</option>
                                    <option data-countryCode="RO" value="40">Romania (+40)</option>
                                    <option data-countryCode="RU" value="7">Russia (+7)</option>
                                    <option data-countryCode="RW" value="250">Rwanda (+250)</option>
                                    <option data-countryCode="SM" value="378">San Marino (+378)</option>
                                    <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                                    <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                                    <option data-countryCode="SN" value="221">Senegal (+221)</option>
                                    <option data-countryCode="CS" value="381">Serbia (+381)</option>
                                    <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                                    <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
                                    <option data-countryCode="SG" value="65">Singapore (+65)</option>
                                    <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
                                    <option data-countryCode="SI" value="386">Slovenia (+386)</option>
                                    <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
                                    <option data-countryCode="SO" value="252">Somalia (+252)</option>
                                    <option data-countryCode="ZA" value="27">South Africa (+27)</option>
                                    <option data-countryCode="ES" value="34">Spain (+34)</option>
                                    <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                                    <option data-countryCode="SH" value="290">St. Helena (+290)</option>
                                    <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
                                    <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
                                    <option data-countryCode="SD" value="249">Sudan (+249)</option>
                                    <option data-countryCode="SR" value="597">Suriname (+597)</option>
                                    <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
                                    <option data-countryCode="SE" value="46">Sweden (+46)</option>
                                    <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                                    <option data-countryCode="SI" value="963">Syria (+963)</option>
                                    <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                                    <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
                                    <option data-countryCode="TH" value="66">Thailand (+66)</option>
                                    <option data-countryCode="TG" value="228">Togo (+228)</option>
                                    <option data-countryCode="TO" value="676">Tonga (+676)</option>
                                    <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                                    <option data-countryCode="TN" value="216">Tunisia (+216)</option>
                                    <option data-countryCode="TR" value="90">Turkey (+90)</option>
                                    <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
                                    <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
                                    <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                                    <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                                    <option data-countryCode="UG" value="256">Uganda (+256)</option>
                                    <!-- <option data-countryCode="GB" value="44">UK (+44)</option> -->
                                    <option data-countryCode="UA" value="380">Ukraine (+380)</option>
                                    <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                                    <option data-countryCode="UY" value="598">Uruguay (+598)</option>
                                    <!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
                                    <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
                                    <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                                    <option data-countryCode="VA" value="379">Vatican City (+379)</option>
                                    <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                                    <option data-countryCode="VN" value="84">Vietnam (+84)</option>
                                    <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
                                    <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
                                    <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                                    <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
                                    <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
                                    <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                                    <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                                </optgroup>
                                <!-- Add more country codes as needed -->
                            </select>
                            <input type="tel" id="whatsapp_number" name="whatsapp_number" class="form-control" placeholder="545xxxx" style="max-width: 250px;" pattern="[0-9]{8,11}">
                        </div>
                        <br><br>
     <input type="hidden" name="pdfurl" value="${pdfUrl}"> <!-- Include formValue in the form -->

                        <button type="submit" id="continueBtn" class="btn btn-primary" disabled>Continue</button>
                    </form>
        <div class="text-center gallery" id="success_loader">
            <img src="{{ asset('assets/images/success.gif') }}" class="" /><br><br>
            <h2 class="w-100">${response.message}</h2>
            <br>

        </div>

`);
                        $('#nextBtn').prop('disabled', true).html('Submitted');

                        var email = document.getElementById('email').value;
                        var whatsappNumber = document.getElementById('whatsapp_number').value;
                        var continueBtn = document.getElementById('continueBtn');

                        // Enable the Continue button if either email or WhatsApp number is filled
                        if (email || whatsappNumber) {
                            continueBtn.disabled = false;
                        } else {
                            continueBtn.disabled = true;
                        }


                        // Call the toggleContinueButton function whenever the email or WhatsApp number input changes
                        document.getElementById('email').addEventListener('input', toggleContinueButton);
                        document.getElementById('whatsapp_number').addEventListener('input', toggleContinueButton);

// Add event listener to the "Skip" button when the DOM content is loaded
                        document.addEventListener('DOMContentLoaded', function() {
                            // Add event listener to the "Skip" button
                            document.getElementById('skipBtn').addEventListener('click', function() {
                                // Hide the form by selecting its parent element with the class "form-card-body"
                                document.querySelector('.form-card-body').style.display = 'none';
                            });
                        });


                    }
                    else {
                        // Display error message
                        showToStr('Error!', response.message, 'danger');
                        $('#nextBtn').removeAttr('disabled');
                        $('#nextBtn').html('Submit');
                        var tabno = $('.tab').length - 1;
                        showTab(tabno);
                    }
                    // Re-enable the form
                    $('#form').show(); // assuming your form has an ID of 'form'
                },
                error: function(error) {
                    // Display error message if AJAX request fails
                    showToStr('Error!', 'Failed to submit form. Please try again later.', 'danger');
                    $('#nextBtn').removeAttr('disabled');
                    $('#nextBtn').html('Submit');
                    var tabno = $('.tab').length - 1;
                    showTab(tabno);
                    // Re-enable the form
                    $('#form').show(); // assuming your form has an ID of 'form'
                }
            });
        }

        $(document).on("click", "input[type='checkbox']", function() {
            var name = $(this).attr('name');
            checkCheckbox(name);
        });
        $("body input[type='checkbox']").each(function(i, item) {
            var name = $(item).attr('name');
            checkCheckbox(name);
        });

        function checkCheckbox(name) {
            if ($("input[name='" + name + "']:checked").length) {
                $("input[name='" + name + "']").removeAttr('required');
            } else {
                $("input[name='" + name + "']").attr('required', 'required');
            }
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $("#setData").trigger('click');
            }, 30);
        });
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'Select Option',
                    searchPlaceholderValue: 'Select Option',
                });
            }
        });
        <script>
            $(document).ready(function() {
            $(".custom_select").select2();
        })
            var $starRating = $('.starRating');
            if ($starRating.length) {
            $starRating.each(function() {
                var val = $(this).attr('data-value');
                var num_of_star = $(this).attr('data-num_of_star');
                $(this).rateYo({
                    rating: val,
                    halfStar: true,
                    numStars: num_of_star,
                    precision: 2,
                    onSet: function(rating, rateYoInstance) {
                        num_of_star = $(rateYoInstance.node).attr('data-num_of_star');
                        var input = ($(rateYoInstance.node).attr('id'));
                        if (num_of_star == 10) {
                            rating = rating * 2;
                        }
                        $('input[name="' + input + '"]').val(rating);
                    }
                })
            });
        }
            if ($(".ck_editor").length) {
            CKEDITOR.replace($('.ck_editor').attr('name'), {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
        }
    </script>
    @if ($form->payment_status == 1)
        <script>
            var stripe, card;
            $(document).ready(function() {
                @if ($form->payment_status == 1)
                    @if ($form->payment_type == 'stripe')
                    stripe = Stripe('{{ Utility::getsettings('STRIPE_KEY') }}');
                var elements = stripe.elements();
                var style = {
                    base: {
                        color: '#32325d',
                        lineHeight: '24px',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '18px',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                };
                // Create an instance of the card Element
                card = elements.create('card', {
                    style: style
                });
                // Add an instance of the card Element into the `card-element` <div>
                card.mount('#card-element');
                // Handle real-time validation errors from the card Element.
                card.addEventListener('change', function(event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });
                @endif
                @if ($form->payment_type == 'paypal')
                var amount = '{{ $form->amount }}';
                var name = '{{ $form->title }}';
                var currency = '{{ $form->currency_name }}';
                var form_id = '{{ $form->id }}';
                paypal.Buttons({
                    // Set up the transaction
                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: amount
                                }
                            }]
                        });
                    },
                    // Finalize the transaction
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(orderData) {
                            // Successful capture! For demo purposes:
                            console.log('Capture result', orderData, JSON.stringify(
                                orderData, null, 2));
                            var transaction = orderData.purchase_units[0].payments.captures[
                                0];
                            $('#payment_id').val(transaction.id);
                            var errorElement = document.getElementById('paypal-errors');
                            errorElement.textContent = '';
                            $('#paypal-button-container').html('')
                        });
                    }
                }).render('#paypal-button-container');
                @endif
                @endif
            })
        </script>
        <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
        <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
        <script>
            // Function to enable or disable the Continue button based on form fields

        </script>
    @endif
@endpush
