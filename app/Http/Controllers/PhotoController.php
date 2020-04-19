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
        //upload file to s3 
        $path = $request->file('image')->store('photos/' . auth()->id());

        //upload photo and connect to currently logged in user
        auth()->user()->photos()->create([
            'name' => basename($path),
            'caption' => $request->caption
        ]);

        //send a flash message
        Session::flash('success', 'Successfully Uploaded Photo');

        //redirect to home page
        return redirect()->route('home');
    }

    public function like(Request $request, Photo $photo)
    {
        //check if like(true) or unlike(false)
        if ($request->like) {
            //attach user as a liker of the photo
            $photo->likers()->attach(auth()->id());
        } else {
            //remove user as a liker of the photo
            $photo->likers()->detach(auth()->id());
        }

        //return current likers count
        return response()->json(['data' => ['message' => 'Success', 'count' => $photo->likers->count()]], 200);
    }
    
    public function comment(CreateCommentRequest $request, Photo $photo)
    {
        //add comment to photo
        $photo->comments()->create([
            'comment' => $request->comment,
            'user_id' => auth()->id()
        ]);
        
        Session::flash('success', 'Successfully Commented');
        return redirect()->route('photos.show', $photo->id);
    }

    public function edit(Photo $photo)
    {
        //check if logged in user is the owner before letting the user in the edit page
        //will be good to add as a middleware instead of here
        if (auth()->id() != $photo->user_id) {
            abort(403);
        }
        
        return view('photos.edit', compact('photo'));
    }

    public function update(Request $request, Photo $photo)
    {
        //check if logged in user is the owner before letting the user update the photo
        //will be good to add as a middleware instead of here
        if (auth()->id() != $photo->user_id) {
            abort(403);
        }

        //update photo caption
        $photo->update($request->all());
        
        Session::flash('success', 'Successfully Updated Caption');
        return redirect()->route('photos.show', $photo->id);
    }

    public function show(Photo $photo)
    {
        //get photo and also its comments likers and user(owner of the photo)
        $photo->load('comments.user', 'likers', 'user');

        return view('photos.show', compact('photo'));
    }

    public function self(Request $request)
    {
        //get currently logged in users uploaded photos
        $groups = auth()->user()->photos();

        //check if sort
        if ($request->sort) {
            $groups = $groups->orderBy('created_at', $request->sort);
        }

        //get photos with likers and comments count then group by date created
        $groups = $groups->withCount('likers', 'comments')->get()->groupBy(function($photo) {
            return \Carbon\Carbon::parse($photo->created_at)->format('Y-m-d');
        });

        return view('photos.self', compact('groups'));
    }

    public function delete(Photo $photo)
    {
        //check if logged in user is the owner before letting the user delete the photo
        //will be good to add as a middleware instead of here
        if (auth()->id() != $photo->user_id) {
            abort(403);
        }

        // delete likes in database
        $photo->likers()->detach();
        // delete comments
        $photo->comments()->delete();
        //delete photo
        $photo->delete();

        return redirect()->route('photos.self');
    }
}
