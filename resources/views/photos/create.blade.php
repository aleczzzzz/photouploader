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
                    <form action="{{route('photos.upload.post')}}" method="post" class="form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label><strong>Upload Files</strong></label>
                            <div class="custom-file">
                              <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="loadFile(event)">
                              <label class="custom-file-label" id="file-label" for="customFile">Choose file</label>
                              @error('image')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                        </div>
                        <div class="card w-25 d-none" id="preview-card">
                            <div class="card-body">
                                <img src="" alt="" id="output" class="upload-preview w-100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="caption">Caption</label>
                            <textarea class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" rows="3" onchange="clearError(event)"></textarea>
                            @error('caption')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <a href="{{route('home')}}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        var loadFile = function(event) {
            $('#preview-card').removeClass('d-none');
            $('#file-label').text(event.target.files[0].name);
            $('#output').attr('src', URL.createObjectURL(event.target.files[0]));
            $('#output').onload = function() {
                URL.revokeObjectURL($('#output').src) // free memory
            }
            clearError(event);
        };

        var clearError = function(event){
            $(this).removeClass('is-invalid');
        }
    </script>
@endpush
