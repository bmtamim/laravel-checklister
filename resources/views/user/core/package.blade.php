@extends('layouts.app')

@section('title','Packages')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="row">
                @if(session()->has('payment_error'))
                    <div class="col-lg-12 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-danger m-0">
                                    {{ session()->get('payment_error') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @foreach($packages as $package)
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5>{{ $package->name ?? __('Default') }}</h5>
                                <h3>
                                    @if($package->compare_price)
                                        ${{ $package->price }} / <span class="font-sm"><del>${{ $package->compare_price }}</del></span>
                                    @else
                                        ${{ $package->price }}
                                    @endif
                                </h3>
                                <h6>{{ $package->billing_type }}</h6>
                                <p>{{ $package->description ?? __('Default') }}</p>

                                @if(auth()->user()->subscribed() && auth()->user()->subscription('primary')->stripe_price == $package->price_id)
                                    <button class="btn btn-dark" disabled="">{{ __('Activated') }}</button>
                                @else
                                    <a href="{{ route('users.payment.create',$package->id) }}"
                                       class="btn btn-primary">{{ __('Upgrade') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

@endsection
