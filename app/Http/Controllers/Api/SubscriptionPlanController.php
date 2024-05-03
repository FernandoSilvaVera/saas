<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionPlanPostRequest;
use App\Models\SubscriptionPlan;
use Exception;
use Illuminate\Http\Request;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::all();

        return response()->json($plans);
    }

    public function store(SubscriptionPlanPostRequest $request)
    {
        try {
            $data = $request->all();

            Stripe::setApiKey(config('services.stripe.secret'));
            $stripe_product = Product::create([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);
            $stripe_monthly_price = Price::create([
                'product' => $stripe_product->id,
                'unit_amount' => $data['monthly_price'] * 100,
                'currency' => config('services.stripe.currency'),
                'recurring' => ['interval' => 'month'],
            ]);
            $stripe_annual_price = Price::create([
                'product' => $stripe_product->id,
                'unit_amount' => $data['annual_price'] * 100,
                'currency' => config('services.stripe.currency'),
                'recurring' => ['interval' => 'year'],
            ]);

/*

*/

            $data['stripe_product_id'] = $stripe_product->id;
            $data['stripe_monthly_price_id'] = $stripe_monthly_price->id;
            $data['stripe_annual_price_id'] = $stripe_annual_price->id;
            $plan = SubscriptionPlan::create($data);
            return response()->json($plan, 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        $data = $request->all();

        $plan->update($data);

        return response()->json($plan);
    }

    public function destroy($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->delete();

        return response()->noContent();
    }
}
