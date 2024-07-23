<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\Product;
use Stripe\PaymentLink;
use Stripe\Stripe;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Subscription\ManageClientSubscription;
use Illuminate\Support\Facades\Http;
use Stripe\Price;
use Stripe\Checkout\Session;

class ProductController extends Controller
{

	public function showAll()
	{
		$products = Product::orderBy('is_active', 'desc')->get();
		return view('listProducts', ['products' => $products]);
	}

	public function editProduct(Request $request)
	{
		$id = $request->input('id');

		if($id){
			$product = Product::find($id);
		}else{
			$product = new Product();
		}

		return view('newProduct', [
			'product' => $product,
		]);
	}

	public function saveProduct(Request $request)
	{
		$data = $request->only(['id', 'name', 'quantity', 'type', 'price']);

		$product = Product::find($data['id']) ?? new Product;
		if(!$product->id){
			$product->fill($data);
			Stripe::setApiKey(config('services.stripe.secret'));
			$stripe_product = \Stripe\Product::create([
				'name' => $data['name'],
			]);

			$product->stripe_product_id = $stripe_product->id;

			$stripe_price = Price::create([
				'product' => $stripe_product->id,
				'unit_amount' => $product->price * 100,
				'currency' => config('services.stripe.currency'),
			]);

			$product->stripe_price_id = $stripe_price->id;

		}else{
			$product->fill($data);
		}
		$product->save();

		return view('newProduct', [
			'product' => $product,
		]);
	}

	public function buyProduct($id)
	{

		Stripe::setApiKey(config('services.stripe.secret'));
		$product = Product::where('stripe_price_id', $id)->first();

		$config = [
			'payment_method_types' => ['card'],
			'line_items' => [[
				'price' => $id,
			'quantity' => 1,
			]],
			'mode' => 'payment',
			'success_url' => url('/history'),
			'cancel_url' => url('/store'),
		];

		$userId = Auth::id();
		$user = User::find($userId);
		$config['customer_email'] = $user->email;
		$session = Session::create($config);

		return redirect($session['url']);

	}
}


