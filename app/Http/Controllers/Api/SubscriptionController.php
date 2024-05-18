<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Exception;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use UnexpectedValueException;
use App\Subscription\ManageClientSubscription;

class SubscriptionController extends Controller
{
    public function createSession(Request $request)
    {
        if (!$request->has('subscription_plan_id')) {
            return response()->json([
                'error' => 'Subscription plan ID is required',
            ], 422);
        }
        if (!$request->has('payment_period')) {
            return response()->json([
                'error' => 'Payment period is required',
            ], 422);
        }
        if (in_array($request->payment_period, ['monthly_price', 'annual_price']) === false) {
            return response()->json([
                'error' => 'Invalid payment period',
            ], 422);
        }

        $plan = SubscriptionPlan::findOrFail($request->subscription_plan_id);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price' => $plan->{'stripe_' . $request->payment_period . '_id'},
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => url('/api/subscriptions/webhook/success?' . http_build_query([
                    'subscription_plan_id' => $plan->id,
                    'payment_period' => $request->payment_period
                ])) . '&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url('/api/susubscriptionsb/webhook/cancel?session_id={CHECKOUT_SESSION_ID}'),
            ]);
            return response()->json($session);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function webhookSuccess(Request $request)
    {
	    $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
	    $customer = $stripe->customers->retrieve("cus_Q89SgmmcpRuYMQ", [ 'expand' => ['subscriptions']]);

	    ManageClientSubscription::update($customer);

        file_put_contents('/tmp/stripe.log', "6", FILE_APPEND);
        Stripe::setApiKey(config('services.stripe.secret'));
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $event = null;
        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                config('services.stripe.webhook_secret')
            );
        } catch (UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid Payload'], 400);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
	
                Subscription::create([
                    'payload' => json_encode($paymentIntent)
                ]);

		$stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
		$customer = $stripe->customers->retrieve($paymentIntent->customer, [ 'expand' => ['subscriptions']]);

		$subs = $customer->subscriptions->data;
		$customer->email;
		$customer->invoice;

                break;
            case 'charge.failed':
                $charge = $event->data->object;
                return response()->json(['error' => 'Charge failed', 'charge' => $charge], 400);
            default:
                return response()->json(['error' => 'Received unknown event type'], 400);
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function webhookCancel(Request $request)
    {
        return response()->json(['status' => 'cancel'], 200);
    }
}
