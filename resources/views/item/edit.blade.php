@extends('layouts.app')

@section('content')
    
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{ __('Edit Item') }}</div>
    
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
    
                    <form action="/item/{{ $item->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="exampleInput" class="form-label">item Name</label>
                            <input type="text" class="form-control" id="exampleInput" name="name" value="{{ $item->name }}">
                        </div>

                        <div class="mb-3">
                            <label for="exampleSelect" class="form-label">Choose Category</label>
                            <select class="form-select" id="exampleSelect" name="category_id">
                                @foreach ($categories as $category)
                                    @if ($item->category->id == $category->id)
                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInput2" class="form-label">Price</label>
                            <input type="number" class="form-control" id="exampleInput2" name="price" value="{{ $item->price }}">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInput2" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="exampleInput3" name="stock" value="{{ $item->stock }}">
                        </div>

                        <div class="mb-3">
                            <a href="/item" class="btn btn-danger btn-sm">Back</a>
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </form>
                </div>    
            </div>

        </div>
    </div>
</div>

@endsection