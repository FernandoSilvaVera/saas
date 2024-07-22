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
}


