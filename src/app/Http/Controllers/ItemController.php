<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ItemController extends Controller
{
    public function index()
    {
        $items1 = Product::take(4)->get();
        $items2 = Product::skip(4)->take(4)->get();

        return view('items/top', compact('items1', 'items2'));
    }

    public function mylist()
    {
        $products = auth()->user()->favorites;
        return view('items.top_mylist', compact('products'));
    }

    public function sell()
    {
        return view('items.sell');
    }

    public function show($id)
    {
        $item = \App\Models\Product::with('categories')->withCount('favoritedByUsers')->findOrFail($id);

        return view('items.item_detail', compact('item'));
    }

    public function purchase($item_id)
    {
        $item = \App\Models\Product::findOrFail($item_id);
        return view('items.purchase', compact('item'));
    }
}
