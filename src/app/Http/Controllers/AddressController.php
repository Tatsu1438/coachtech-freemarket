<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class AddressController extends Controller
{
    public function edit($item_id)
    {
        $item = Product::findOrFail($item_id);
        $user = auth()->user();

        return view('address.address', compact('item', 'user'));
    }

    public function update(Request $request, $item_id)
    {
        $request->validate([
            'postal_code' => 'required|max:8',
            'address' => 'required',
            'building' => 'nullable',
        ]);

        $user = auth()->user();
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect()->route('items.purchase', ['item_id' => $item_id])->with('success', '住所を更新しました');
    }
}
