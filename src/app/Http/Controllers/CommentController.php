<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Product $item)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if (!auth()->check()) {
            $validator->after(function ($validator) {
                $validator->errors()->add('comment', 'コメントするにはログインが必要です');
            });
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Comment::create([
            'user_id'    => auth()->id(),
            'product_id' => $item->id,
            'comment'    => $request->comment,
        ]);

        return back()->with('success', 'コメントを投稿しました！');
    }
}
