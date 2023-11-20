@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-8">

            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-header">{{ __('Categories') }}</div>
    
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
    
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <th scope="col">{{ $loop->iteration }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <form action="/category/{{ $category->id}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="/category/{{ $category->id }}/edit" class="btn btn-success">Edit</a>
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Syur kh?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Add Category') }}</div>
    
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
    
                    <form action="/category" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInput" class="form-label">Category Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInput" name="name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-primary">Add</button>
                        </div>
                    </form>
                </div>    
            </div>
        </div>

    </div>
</div>

@endsection