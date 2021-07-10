@extends('layouts.app')

@section('title','Payment')
@push('styles')
    <style>
        #card-button img {
            display: none;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Package Details') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-borderless">
                        <tbody>
                        <tr>
                            <td>Name</td>
                            <td style="width: 20px;text-align: center">:</td>
                            <td>{{ $package->name ?? __('Default')  }}</td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td style="width: 20px;text-align: center">:</td>
                            <td>
                                @if($package->compare_price)
                                    ${{ $package->price }} / <span class="font-sm"><del>${{ $package->compare_price }}</del></span>
                                @else
                                    ${{ $package->price }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Billing Period</td>
                            <td style="width: 20px;text-align: center">:</td>
                            <td>{{ ucfirst( $package->billing_type) ?? __('Default')  }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td style="width: 20px;text-align: center">:</td>
                            <td>{{ $package->description ?? __('Default')  }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Pay with Debit/Credit Card') }}</h5>
                </div>
                <div class="card-body">
                <!-- <div class="form-group">
                        <input id="card-holder-name" class="form-control" type="text"
                               placeholder="{{ __('Card holder name') }}">
                    </div> -->
                    <div class="form-group">
                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element"></div>
                    </div>
                    <div class="form-group text-center">
                        <button id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-dark w-100"
                                data-style="expand-left">
                            <img src="{{ asset('images/ajax-white-loader.svg') }}" width="20"/> Pay
                            ${{ $package->price }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        window.addEventListener('load', function () {
            const stripe = Stripe('{{ env('stripe_key') }}');

            const elements = stripe.elements();
            const cardElement = elements.create('card', {
                iconStyle: 'solid',
                style: {
                    base: {
                        iconColor: '#c4f0ff',
                        color: '#768192',
                        fontWeight: 400,
                        fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
                        fontSize: '16px',
                        fontSmoothing: 'antialiased',
                        border: '1px solid #d8dbe0',

                        ':-webkit-autofill': {
                            color: '#fce883',
                        },
                        '::placeholder': {
                            color: '#8a93a2',
                            fontWeight: 400,
                        },
                    },
                    invalid: {
                        iconColor: '#F54748',
                        color: '#F54748',
                    },
                },
            });

            cardElement.mount('#card-element');

            // const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            cardButton.addEventListener('click', async (e) => {
                $('#card-button img').addClass('d-inline-block');
                $('#card-button').prop('disabled', true);

                const {setupIntent, error} = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                        }
                    }
                );

                if (error) {
                    $('#card-button img').removeClass('d-inline-block');
                    $('#card-button').prop('disabled', false);
                } else {
                    $.ajax({
                        url: '{{ route('users.payment.store',$package->id) }}',
                        method: 'POST',
                        data: {"payment_method": setupIntent.payment_method, "_token": "{{ csrf_token() }}"},
                        beforeSend: function () {
                            $('#card-button img').addClass('d-inline-block');
                            $('#card-button').prop('disabled', true);
                        },
                        success: function (data) {
                            if (data.stripe_status == 'active') {
                                window.location.replace('{{ route('home') }}');
                            } else {
                                window.location.replace('{{ route('users.packages') }}');
                            }
                        },
                        complete: function () {
                            $('#card-button img').removeClass('d-inline-block');
                            $('#card-button').prop('disabled', false);
                        },
                    });
                }
            });
        });
    </script>
@endpush
