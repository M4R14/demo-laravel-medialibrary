@extends('layouts.app')

@push('css')
<style>
    picture img {
        width: 100%
    }
</style>
@endpush

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header">new post</div> --}}

                <form enctype="multipart/form-data" action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <textarea class="form-control" name="content"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="file" name="images" >
                        </div>
                        <button class="btn btn-primary">submit</button>
                    </div>
                </form>
            </div>
            <hr>
            @foreach ($posts as $item)
                <div class="card mb-3">
                    <div class="card-body pb-1">
                        <p>
                            {!! $item->content !!}
                        </p>
                    </div>
                    <picture>
                        {{ $item->getMedia()->first() }}
                    </picture>
                </div>
            @endforeach
            
        </div>
    </div>
</div>
@endsection
