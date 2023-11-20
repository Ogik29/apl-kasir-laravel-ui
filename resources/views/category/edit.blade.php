@extends('layouts.app')

@section('content')
    
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{ __('Edit Category') }}</div>
    
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
    
                    <form action="/category/{{ $category->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="exampleInput" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="exampleInput" name="name" value="{{ $category->name }}">
                        </div>

                        <div class="mb-3">
                            <a href="/category" class="btn btn-danger btn-sm">Back</a>
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </form>
                </div>    
            </div>

        </div>
    </div>
</div>

@endsection