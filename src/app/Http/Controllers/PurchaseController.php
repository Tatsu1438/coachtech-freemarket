<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Product::findOrFail($item_id);
        $user = Auth::user();

        Purchase::create([
            'user_id'        => $user->id,
            'item_id'        => $item->id,
            'payment_method' => $request->payment_method,
            'price'          => $item->price,
            'postal_code'    => $request->postal_code,
            'address'        => $request->address,
            'building'       => $request->building,
        ]);

        return redirect()->route('profile.bought')->with('success', '購入が完了しました！');
    }
}