@extends('layouts.app')

@section('title', 'Create Portfolio - Sultan Agung Portfolio')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Create New Portfolio</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Back to Dashboard</a>
    </div>

    <form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Portfolio Details</h2>
            
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Portfolio Title</label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter portfolio title"
                       value="{{ old('title') }}"
                       required>
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Portfolio Contents</h2>
            
            <div id="contents-container">
                <div class="content-item border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Content 1</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                            <input type="file" 
                                   name="contents[0][image]" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   accept="image/*"
                                   required>
                            @error('contents.0.image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="contents[0][description]" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Enter content description"
                                      required>{{ old('contents.0.description') }}</textarea>
                            @error('contents.0.description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="button" id="add-content" class="btn-secondary">Add More Content</button>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="btn-primary">Create Portfolio</button>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let contentIndex = 1;
    const addContentBtn = document.getElementById('add-content');
    const contentsContainer = document.getElementById('contents-container');
    
    addContentBtn.addEventListener('click', function() {
        const contentHtml = `
            <div class="content-item border border-gray-200 rounded-lg p-4 mb-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Content ${contentIndex + 1}</h3>
                    <button type="button" class="remove-content text-red-600 hover:text-red-800 font-medium">Remove</button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                        <input type="file" 
                               name="contents[${contentIndex}][image]" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               accept="image/*"
                               required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="contents[${contentIndex}][description]" 
                                  rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Enter content description"
                                  required></textarea>
                    </div>
                </div>
            </div>
        `;
        
        contentsContainer.insertAdjacentHTML('beforeend', contentHtml);
        contentIndex++;
    });
    
    // Event delegation for remove buttons
    contentsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-content')) {
            e.target.closest('.content-item').remove();
        }
    });
});
</script>
@endsection