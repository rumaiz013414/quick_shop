@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Edit T-Shirt</h1>
    <form action="{{ route('tshirts.update', $tshirt->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded-lg" value="{{ $tshirt->name }}" required>
        </div>

        <div class="mb-4">
            <label for="color" class="block text-gray-700 text-sm font-bold mb-2">Color</label>
            <input type="text" name="color" class="w-full p-2 border border-gray-300 rounded-lg" value="{{ $tshirt->color }}" required>
        </div>

        <div class="mb-4">
            <label for="size" class="block text-gray-700 text-sm font-bold mb-2">Size</label>
            <input type="text" name="size" class="w-full p-2 border border-gray-300 rounded-lg" value="{{ $tshirt->size }}" required>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price</label>
            <input type="number" name="price" class="w-full p-2 border border-gray-300 rounded-lg" value="{{ $tshirt->price }}" required>
        </div>

        <div class="mb-4">
            <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
            <input type="number" name="stock" class="w-full p-2 border border-gray-300 rounded-lg" value="{{ $tshirt->stock }}" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">Update T-Shirt</button>
    </form>
</div>
@endsection
