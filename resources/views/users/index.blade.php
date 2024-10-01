@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center">Manage Users</h1>

    @if (session('message'))
        <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow mx-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Name</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Email</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b border-gray-200 text-center">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-center">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-center">
                            <a href="{{ route('users.edit', $user->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block ml-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
