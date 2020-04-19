@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Upload Photo
                </div>
                <div class="card-body">
                    <form action="{{route('photos.update', $photo->id)}}" method="post" class="form" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="card w-100" id="preview-card">
                            <div class="card-body text-center bg-dark">
                                <img src="{{$photo->path}}" alt="" id="output" class="upload-preview object-fit-none">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="caption">Caption</label>
                            <textarea class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" rows="3" onchange="clearError(event)">{!!$photo->caption!!}</textarea>
                            @error('caption')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{route('photos.show', $photo->id)}}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection