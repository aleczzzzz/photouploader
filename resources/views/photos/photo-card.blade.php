<div class="card text-dark text-decoration-none">
    <div class="card-header">
        <p class="card-text"><strong>{{$photo->user->name}}</strong></p>
    </div>
    <a href="{{route('photos.show', $photo->id)}}">
        <img class="card-img-top photo-card-img" src="{{$photo->path}}" alt="Card image cap">
    </a>
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <button class="btn-like no-design {{$photo->likers->where('id', auth()->id())->first() ? 'text-primary' : ''}}"
                    data-url={{route('photos.like', $photo->id)}}>
                    <span class="liker-count">{{$photo->likers_count}}</span>
                    <i class="like-icon fa fa-thumbs-up"></i>
                </button>
                <span>{{$photo->comments_count}}</span> <i class="fa fa-comments"></i>
            </div>
        </div>
    </div>
    <div class="card-body">
        <p class="card-text mb-0">{{$photo->caption}}</p>
        <sub class="card-text d-block mt-0 line-height-1"><small>{{$photo->created_at->ago()}}</small></sub>
    </div>
</div>