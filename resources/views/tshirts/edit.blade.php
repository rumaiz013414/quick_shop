@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit T-Shirt</h1>
    <form action="{{ route('tshirts.update', $tshirt->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $tshirt->name }}" required>
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" name="color" class="form-control" value="{{ $tshirt->color }}" required>
        </div>
        <div class="form-group">
            <label for="size">Size</label>
            <input type="text" name="size" class="form-control" value="{{ $tshirt->size }}" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" value="{{ $tshirt->price }}" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ $tshirt->stock }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update T-Shirt</button>
    </form>
</div>
@endsection
