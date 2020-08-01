<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());
        if (request()->expectsJson()) {
            return response()->json(null, 204);
        }
        return back();
    }

    public function destory(Question $question)
    {
        $question->favorites()->detach(auth()->id());
        if (request()->expectsJson()) {
            // execute successfuly and no returned message
            return response()->json(null, 204);
        }
        return back();
    }
}
