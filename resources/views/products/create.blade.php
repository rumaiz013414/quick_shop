@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold">Add Product</h1>
@endsection

@section('content')
    <div class="p-6">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Name</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Description</label>
                <textarea name="description" id="description" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300"></textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium">Price</label>
                <input type="number" name="price" id="price" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4">
                <label for="image_url" class="block text-sm font-medium">Image URL</label>
                <input type="text" name="image_url" id="image_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Product</button>
        </form>
    </div>
@endsection
