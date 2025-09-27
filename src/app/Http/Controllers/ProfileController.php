<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function sellList(Request $request)
    {
        $query = Product::where('user_id', Auth::id())
                            ->with('purchases')
                            ->orderBy('created_at', 'desc');

        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
        }

        $products = $query->paginate(8);

        return view('profile.mypage_sold', compact('products'));
    }

    public function myProducts()
    {
        $user = Auth::user();
        $my_products = Product::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('profile.mypage_sold', compact('my_products'));
    }

    public function buyList(Request $request)
    {
        $query = Purchase::with('product')
                            ->where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc');

        if ($request->filled('keyword')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('product_name', 'like', '%' . $request->keyword . '%');
            });
        }

        $purchases = $query->paginate(8);

        return view('profile.mypage_bought', compact('purchases'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.mypage_edit');
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        if ($request->hasFile('icon')) {
            if ($user->icon) {
                Storage::disk('public')->delete($user->icon);
            }
            $path = $request->file('icon')->store('icons', 'public');
            $user->icon = $path;
        }
        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;

        $user->save();


        return redirect()->route('profile.sold')
        ->with('success', 'プロフィールを更新しました！');
    }

    public function updateFirst(ProfileRequest $request)
    {
        $user = auth()->user();

        if ($request->hasFile('icon')) {
            if ($user->icon) {
                Storage::disk('public')->delete($user->icon);
            }
            $path = $request->file('icon')->store('icons', 'public');
            $user->icon = $path;
        }
        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;

        $user->save();


        return redirect()->route('items.top_mylist')
        ->with('success', 'プロフィールを登録しました！');
    }
}
