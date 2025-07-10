@extends('layouts.app')

@section('title', 'Edit Portfolio - Sultan Agung Portfolio')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Portfolio</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-8">
            {{ session('success') }}
        </div>
    @endif

    <!-- Edit Portfolio Title -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Portfolio Details</h2>
        
        <form method="POST" action="{{ route('admin.update', $portfolio->id) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Portfolio Title</label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter portfolio title"
                       value="{{ old('title', $portfolio->title) }}"
                       required>
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="btn-primary">Update Portfolio</button>
        </form>
    </div>

    <!-- Existing Contents -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Portfolio Contents</h2>
        
        @if($portfolio->contents->count() > 0)
            <div class="grid gap-6">
                @foreach($portfolio->contents as $content)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <img src="{{ asset('storage/' . $content->image_path) }}" 
                                     alt="Content Image"
                                     class="w-full h-48 object-cover rounded-lg">
                            </div>
                            <div>
                                <p class="text-gray-700 mb-4">{{ $content->description }}</p>
                                <form method="POST" action="{{ route('content.destroy', $content->id) }}" 
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this content?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger text-sm">Delete Content</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No contents available.</p>
        @endif
    </div>

    <!-- Add New Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Add New Content</h2>
        
        <form method="POST" action="{{ route('content.store', $portfolio->id) }}" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                    <input type="file" 
                           name="image" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           accept="image/*"
                           required>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Enter content description"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <button type="submit" class="btn-primary">Add Content</button>
        </form>
    </div>
</div>
@endsection