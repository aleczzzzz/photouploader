@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h2>My Photos</h2>
        </div>
        <div class="col-md-3 text-right"><div class="d-block text-right mt-2">Sort By</div></div>
        <div class="col-md-3">
            <form action="{{route('home')}}" method="get" id="filter-form">
                <select name="sort" id="sort" class="form-control" onchange="this.form.submit()">
                    <option value="asc" {{Request::get('sort') == 'asc' ? 'selected' : ''}}>Date Uploaded Ascending</option>
                    <option value="desc" {{Request::get('sort') == 'desc' ? 'selected' : ''}}>Date Uploaded Decending</option>
                </select>
            </form>
        </div>
    </div>
    @forelse ($groups as $key => $group)
        <h3 class="mt-3">{{\Carbon\Carbon::parse($key)->format('F j, Y')}}</h3>
        <div class="row mt-2">
            @forelse ($group as $photo)
                <div class="col-md-4">
                    @include('photos.photo-card')
                </div>
            @empty
                <h3 class="text-center mt-3">No Photos Uploaded</h3>
            @endforelse
        </div>
    @empty
        <h3 class="text-center mt-3">No Photos Uploaded</h3>
    @endforelse
</div>
@endsection