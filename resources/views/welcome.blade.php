@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @forelse ($photos as $photo)
            <div class="col-4">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="{{$photo->path}}" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        @empty
        
        @endforelse
    </div>
</div>
@endsection
