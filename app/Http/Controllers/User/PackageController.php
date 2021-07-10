<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Cashier\Subscription;
use Stripe\Stripe;

class PackageController extends Controller
{

    //
    public function index()
    {
        if (auth()->user()->subscribed('primary')) {
            return self::redirectToBillingPortalIfSubscribed();
        }
        $packages = Package::query()->take(3)->get();
        return view('user.core.package', compact('packages',));
    }

    public function payment($package_id)
    {
        if (auth()->user()->subscribed('primary')) {
            return self::redirectToBillingPortalIfSubscribed();
        }

        $package = Package::query()->findOrFail($package_id);
        $intent = auth()->user()->createSetupIntent();

        return view('user.core.payment', compact('intent', 'package'));

    }

    public function storePayment(Request $request, $package_id)
    {
        if (auth()->user()->subscribed('primary')) {
            return self::redirectToBillingPortalIfSubscribed();
        }

        $package = Package::query()->findOrFail($package_id);
        $paymentMethod = $request->payment_method;
        $subscription = Auth::user()->newSubscription('primary', $package->price_id)->create($paymentMethod);
        if ($subscription['stripe_status'] != 'active') {
            Session::flash('payment_error', 'Sorry,Payment failed. Please, try again later!');
        }
        return response()->json($subscription);

    }

    public static function redirectToBillingPortalIfSubscribed(): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('users.billing_portal');
    }
}
