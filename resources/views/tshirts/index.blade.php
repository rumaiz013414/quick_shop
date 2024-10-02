@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4 text-center">Products</h1>
    <a href="{{ route('tshirts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Add New Product</a>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow mx-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">ID</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Name</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Color</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Size</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Price</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Quantity</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tshirts as $tshirt)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b border-gray-200 text-center">{{ $tshirt->id }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-center">{{ $tshirt->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-center">{{ $tshirt->color }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-center">{{ $tshirt->size }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-center">${{ $tshirt->price }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-center">{{ $tshirt->stock }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-center">
                            <a href="{{ route('tshirts.edit', $tshirt->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                            <form action="{{ route('tshirts.destroy', $tshirt->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
