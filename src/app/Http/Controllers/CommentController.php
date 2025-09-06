<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;

class CommentController extends Controller
{
    public function store(Request $request, Product $item)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        Comment::create([
            'user_id'    => auth()->id(),
            'product_id' => $item->id,
            'comment'    => $request->comment,
        ]);

        return back()->with('success', 'コメントを投稿しました！');
    }
}
