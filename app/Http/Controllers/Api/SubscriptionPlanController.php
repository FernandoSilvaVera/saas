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

		$id = $data['id'];

		if(!$data['word_limit']){
			$data['word_limit'] = 1;
		}

		if($id){
			$plan = SubscriptionPlan::find($id);
			$plan->name = $data['name'];
			$plan->word_limit = $data['word_limit'];
			$plan->summaries = $data['summaries'];
			$plan->voiceover = $data['voiceover'];
			$plan->test_questions_count = $data['test_questions_count'];
			$plan->is_active = true;
			$plan->unlimited_words = $data['wordNoLimit'];
			$plan->concept_map = $data['conceptualMap'];
			$plan->custom_plan = $data['customPlan'];
			$plan->save();
			return response()->json($plan, 201);
		}

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
	    $data['is_active'] = true;
	    $data['unlimited_words'] = $data['wordNoLimit'];
	    $data['concept_map'] = $data['conceptualMap'];
	    $data['custom_plan'] = $data['customPlan'];

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

	public function desactive(Request $request)
	{
            $data = $request->all();
	    $plan = SubscriptionPlan::find($data['id']);
	    $plan->is_active = false;
	    $plan->save();
	    return $plan;
	}

	public function active(Request $request)
	{
            $data = $request->all();
	    $plan = SubscriptionPlan::find($data['id']);
	    $plan->is_active = true;
	    $plan->save();
	    return $plan;
	}









}
