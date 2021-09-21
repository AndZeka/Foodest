<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;


class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }   

    // public function index() {
    //     $comment = Comment::where('restaurant_id', auth()->user()->id)->with('product')->get();

    //     return view('basket', compact('baskets')); //
    // }

    public function store(Request $request){
        $user_id = auth()->user()->id;
        $restaurant_id = $request->restaurant_id;
        $message = $request->message;
        $slug = $request->slug;

        Comments::create([
            'restaurant_id' => $restaurant_id,
            'user_id' => $user_id,
            'message' => $message
        ]);

        return redirect()->to("/restaurant/".$slug);
    }
}
