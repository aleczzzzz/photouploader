<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadPhotoRequest;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Photo;
use Session;
use Illuminate\Support\Facades\DB;

class PhotoController extends Controller
{

    public function create()
    {
        return view('photos.create');
    }

    public function store(UploadPhotoRequest $request)
    {   
        $path = $request->file('image')->store('photos/' . auth()->id(), ['disk' => 'public']);

        auth()->user()->photos()->create([
            'name' => basename($path),
            'caption' => $request->caption
        ]);

        Session::flash('success', 'Successfully Uploaded Photo');
        return redirect()->route('home');
    }

    public function like(Request $request, Photo $photo)
    {
        if ($request->like) {
            $photo->likers()->attach(auth()->id());
        } else {
            $photo->likers()->detach(auth()->id());
        }

        return response()->json(['data' => ['message' => 'Success', 'count' => $photo->likers->count()]], 200);
    }
    
    public function comment(CreateCommentRequest $request, Photo $photo)
    {
        $photo->comments()->create([
            'comment' => $request->comment,
            'user_id' => auth()->id()
        ]);

        Session::flash('success', 'Successfully Commented');
        return redirect()->route('photos.show', $photo->id);
    }

    public function edit(Photo $photo)
    {
        return view('photos.edit', compact('photo'));
    }

    public function update(Request $request, Photo $photo)
    {
        $photo->update($request->all());

        Session::flash('success', 'Successfully Updated Caption');
        return redirect()->route('photos.show', $photo->id);
    }

    public function show(Photo $photo)
    {
        $photo->load('comments.user', 'likers', 'user');

        return view('photos.show', compact('photo'));
    }

    public function self(Request $request)
    {
        $groups = auth()->user()->photos();

        if ($request->sort) {
            $groups = $groups->orderBy('created_at', $request->sort);
        }

        $groups = $groups->withCount('likers', 'comments')->get()->groupBy(function($photo) {
            return \Carbon\Carbon::parse($photo->created_at)->format('Y-m-d');
        });

        return view('photos.self', compact('groups'));
    }

    public function delete(Photo $photo)
    {
        $photo->likers()->detach();
        $photo->comments()->delete();
        $photo->delete();

        return redirect()->route('photos.self');
    }
}
