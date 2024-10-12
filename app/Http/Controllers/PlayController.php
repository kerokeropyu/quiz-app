<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;

class PlayController extends Controller
{
    public function top(): View
    {
        $categories = Category::all();
        return view('play.top', compact('categories'));
    }
}
