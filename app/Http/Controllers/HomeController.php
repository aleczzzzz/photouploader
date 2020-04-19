<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $groups = Photo::withCount('likers', 'comments');

        if ($request->sort) {
            $groups = $groups->orderBy('created_at', $request->sort);
        }

        $groups = $groups->get()->groupBy(function($photo) {
            return \Carbon\Carbon::parse($photo->created_at)->format('Y-m-d');
        });

        return view('home', compact('groups'));
    }
}
