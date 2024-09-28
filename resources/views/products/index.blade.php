@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold">Products</h1>
@endsection

@section('content')
    <div class="p-6">
        <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Product</a>

        @if(session('success'))
            <div class="mt-4 text-green-500">{{ session('success') }}</div>
        @endif

        <table class="min-w-full mt-4 bg-white">
            <thead>
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $product->id }}</td>
                        <td class="border px-4 py-2 text-center">{{ $product->name }}</td>
                        <td class="border px-4 py-2">{{ $product->description }}</td>
                        <td class="border px-4 py-2 text-center">{{ $product->price }}</td>
                        <td class="border px-4 py-2 text-center">
                            <a href="{{ route('products.edit', $product) }}" class="text-blue-500">Edit</a>
                            <span class="text-gray-300">|</span>

                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
