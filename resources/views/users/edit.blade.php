@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit User: {{ $user->name }}</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block">Name</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full p-2 border border-gray-300 rounded">
        </div>
        
        <div class="mb-4">
            <label for="email" class="block">Email</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-full p-2 border border-gray-300 rounded">
        </div>
        
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update User</button>
    </form>
@endsection
