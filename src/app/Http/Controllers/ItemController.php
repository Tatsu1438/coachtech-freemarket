<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class ItemController extends Controller
{
    public function index()
    {
        $items = Product::whereNull('user_id')->with('purchases')->get();
        $my_products = Product::whereNotNull('user_id')->with('purchases')->get();
        $all_items = $items->merge($my_products);

        $perPage = 8;
        $currentPage = request()->get('page', 1);
        $currentItems = $all_items->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedItems = new LengthAwarePaginator(
            $currentItems,
            $all_items->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('items.top', ['all_items' => $paginatedItems]);
    }

    public function mylist(Request $request)
    {
        $keyword = $request->input('keyword');

        $items = Product::whereNull('user_id')->with('purchases', 'categories')->get();
        $my_products = Product::whereNotNull('user_id')->with('purchases', 'categories')->get();
        $all_items = $items->merge($my_products);

        $user = auth()->user();
        if (!$user) {
            return redirect()->route('items.top');
        }

        $favoritesIds = $user->favorites()->pluck('product_id')->toArray();

        $favoriteItems = $all_items->filter(function($item) use ($favoritesIds) {
            return in_array($item->id, $favoritesIds);
        });

        if (!empty($keyword)) {
            $favoriteItems = $favoriteItems->filter(function ($item) use ($keyword) {
                return stripos($item->product_name, $keyword) !== false ||
                    $item->categories->contains(function ($category) use ($keyword) {
                        return stripos($category->category, $keyword) !== false;
                    });
            });
        }


        $perPage = 8;
        $currentPage = request()->get('page', 1);
        $currentItems = $favoriteItems ->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedItems = new LengthAwarePaginator(
            $currentItems,
            $favoriteItems->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('items.top_mylist', ['all_favorite_items' => $paginatedItems]);
    }

    public function sell()
    {
        return view('items.sell');
    }

    public function show($id)
    {
        $item = \App\Models\Product::with('categories','comments', 'favoritedByUsers')->withCount('favoritedByUsers' , 'comments')->findOrFail($id);


        return view('items.item_detail', compact('item'));
    }

    public function purchase($item_id)
    {
        $item = \App\Models\Product::findOrFail($item_id);
        $user = auth()->user();

        return view('items.purchase', compact('item','user'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $all_items = Product::with('purchases', 'categories')
            ->where('product_name', 'like', "%{$keyword}%")
            ->orWhereHas('categories', function ($query) use ($keyword) {
                $query->where('category', 'like', "%{$keyword}%");
            })
            ->paginate(8);

        return view('items.top', compact('all_items', 'keyword'));
    }

    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();
        $path = $request->file('img_url')->store('images', 'public');

        $product = Product::create([
            'product_name' => $validated['product_name'],
            'brand'       => $request->brand,
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'condition'   => $validated['condition'],
            'img_url'         => $path,
            'user_id'     => auth()->id(),
        ]);

        $categories = $validated['category'];
        $categoryIds = [];

        foreach ($categories as $catName) {
            $category = \App\Models\Category::firstOrCreate(
                ['category' => $catName]
            );
            $categoryIds[] = $category->id;
        }

        $product->categories()->attach($categoryIds);

        return redirect()->route('items.top')->with('success', '商品を出品しました！');
    }
}
