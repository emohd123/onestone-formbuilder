@extends('layouts.main')
@section('title', __('Whatsapp Verification'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Whatsapp Verification') }}</h4>
        </div>
    </div>
@endsection
@section('content')
    <style>
        .height-100 {
            height: 100vh
        }

        .card {
            width: 400px;
            border: none;
            height: 300px;
            box-shadow: 0px 5px 20px 0px #d2dae3;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .card h6 {
            color: red;
            font-size: 20px
        }

        .inputs input {
            width: 46px;
            height: 40px;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0
        }

        .card-2 {
            background-color: #fff;
            padding: 10px;
            width: 350px;
            height: 100px;
            bottom: -50px;
            left: 20px;
            position: absolute;
            border-radius: 5px
        }

        .card-2 .content {
            margin-top: 50px
        }

        .card-2 .content a {
            color: red
        }

        .form-control:focus {
            box-shadow: none;
            border: 2px solid red
        }

        .validate {
            border-radius: 20px;
            height: 40px;
            background-color: red;
            border: 1px solid red;
            width: 140px
        }
    </style>

    <div class="container height-100 d-flex justify-content-center align-items-center">
        <div class="position-relative">
            <div class="card p-2 text-center">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ route('verifyOtp') }}" method="POST">
                    @csrf
                    <h6>Please enter the one-time password <br> to verify your account</h6>
                    <div><span>A code has been sent to</span> <small>{{ $hiddenNumber }}</small></div>
                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                        <input class="m-2 text-center form-control rounded otp-input" type="text" name="first" maxlength="1" />
                        <input class="m-2 text-center form-control rounded otp-input" type="text" name="second" maxlength="1" />
                        <input class="m-2 text-center form-control rounded otp-input" type="text" name="third" maxlength="1" />
                        <input class="m-2 text-center form-control rounded otp-input" type="text" name="fourth" maxlength="1" />
                        <input class="m-2 text-center form-control rounded otp-input" type="text" name="fifth" maxlength="1" />
                        <input class="m-2 text-center form-control rounded otp-input" type="text" name="sixth" maxlength="1" />
                    </div>
                    <input type="hidden" value="" name="phone">
                    <div class="mt-4">
                        <button class="btn btn-danger px-4 validate">Validate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
    document.addEventListener("DOMContentLoaded", function(event) {

        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > *[id]');
            for (let i = 0; i < inputs.length; i++) { inputs[i].addEventListener('keydown', function(event) { if (event.key==="Backspace" ) { inputs[i].value='' ; if (i !==0) inputs[i - 1].focus(); } else { if (i===inputs.length - 1 && inputs[i].value !=='' ) { return true; } else if (event.keyCode> 47 && event.keyCode < 58) { inputs[i].value=event.key; if (i !==inputs.length - 1) inputs[i + 1].focus(); event.preventDefault(); } else if (event.keyCode> 64 && event.keyCode < 91) { inputs[i].value=String.fromCharCode(event.keyCode); if (i !==inputs.length - 1) inputs[i + 1].focus(); event.preventDefault(); } } }); } } OTPInput(); });

</script>
    <script>
        $(document).ready(function() {
            // Select all input fields with class 'otp-input'
            $('.otp-input').on('input', function(e) {
                // Get the length of the entered digit
                var digitLength = $(this).val().length;

                // If a digit is entered and the length is less than the maximum length (1 in this case)
                if (digitLength > 0 && digitLength < 2) {
                    // Find the next input field
                    var nextInput = $(this).next('.otp-input');

                    // If the next input field exists, focus on it
                    if (nextInput.length > 0) {
                        nextInput.focus();
                    }
                } else if (digitLength === 0) {
                    // If backspace is pressed and the input field is empty
                    var prevInput = $(this).prev('.otp-input');

                    // If the previous input field exists, focus on it
                    if (prevInput.length > 0) {
                        prevInput.focus();
                    }
                }
            });
        });
    </script>


@endsection

