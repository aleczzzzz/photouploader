@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card text-dark text-decoration-none">
        <div class="card-header">
            <p class="card-text"><strong>{{$photo->user->name}}</strong></p>
        </div>
        <img class="object-fit-none" src="{{$photo->path}}" alt="Card image cap">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <button class="btn-like no-design {{$photo->likers->where('id', auth()->id())->first() ? 'text-primary' : ''}}"
                        data-url={{route('photos.like', $photo->id)}}>
                        <span class="liker-count">{{$photo->likers->count()}}</span>
                        <i class="like-icon fa fa-thumbs-up"></i>
                    </button>
                    <span>{{$photo->comments->count()}}</span> <i class="fa fa-comments"></i>
                </div>
                @auth
                <div class="col-6 text-right">
                    <button class="btn btn-sm btn-primary" id="btn-comment">Comment</button>
                    @if (auth()->id() == $photo->user_id)
                        <a href="{{route('photos.edit', $photo->id)}}" class="btn btn-sm btn-success">Edit</a>
                        <button class="btn btn-sm btn-danger" onclick="event.preventDefault();
                                        confirm('Are you sure?') ? document.getElementById('delete-photo-form').submit() : null;">Delete</button>

                        <form id="delete-photo-form" action="{{ route('photos.delete', $photo->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
                @endauth
            </div>
        </div>
        <div class="card-body">
            <p class="card-text mb-0">{{$photo->caption}}</p>
            <sub class="card-text d-block mt-0 line-height-1"><small>{{$photo->created_at->ago()}}</small></sub>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-text">Comments</h5>
        </div>
        <div class="card-body">
            <div>
                <ul class="list-group list-group-flush">
                    @forelse ($photo->comments as $comment)
                        <li class="list-group-item">
                            <div class="w-100 text-right">
                                <small>{{$comment->created_at->ago()}}</small>
                            </div>
                            <p class="mb-1"><strong>{{$comment->user->name}}</strong> {{$comment->comment}}</p>
                        </li>
                    @empty
                        <h4>No comments yet.</h4>
                    @endforelse
                </ul>
            </div>
            <form action="{{route('photos.comment', $photo->id)}}" method="post" id="comment-form" class="mt-3 @guest d-none @endguest">
                @csrf
                <div class="form-group">
                    <textarea name="comment" id="" cols="30" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection