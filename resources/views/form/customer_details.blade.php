@extends('layouts.form')
@section('title', __('Fill'))
@section('content')

    <style>
        .formcustomer {
            width: 300px;
        }
           .intl-tel-input {
               display: table-cell;
           }
        .intl-tel-input .selected-flag {
            z-index: 4;
        }
        .intl-tel-input .country-list {
            z-index: 5;
        }
        .input-group .intl-tel-input .form-control {
            border-top-left-radius: 4px;
            border-top-right-radius: 0;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 0;
        }
    </style>

    <div class="section-body">
        <div class="mx-0 mt-5 row">
            <div class="mx-auto col-md-7">



                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-center w-100"></h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center gallery" id="success_loader">
                                <img src="{{ asset('assets/images/success.gif') }}" />
                                <br>
                                <br>
                                <h2 class="w-100 ">Thanks for sharing your contact details.</h2>

                            </div>

                        </div>

                    </div>


            </div>


            <script>
                // Function to enable or disable the Continue button based on form fields
                function toggleContinueButton() {
                    var email = document.getElementById('email').value;
                    var whatsappNumber = document.getElementById('whatsapp_number').value;
                    var continueBtn = document.getElementById('continueBtn');

                    // Enable the Continue button if either email or WhatsApp number is filled
                    if (email || whatsappNumber) {
                        continueBtn.disabled = false;
                    } else {
                        continueBtn.disabled = true;
                    }
                }

                // Call the toggleContinueButton function whenever the email or WhatsApp number input changes
                document.getElementById('email').addEventListener('input', toggleContinueButton);
                document.getElementById('whatsapp_number').addEventListener('input', toggleContinueButton);

            </script>


@endsection

