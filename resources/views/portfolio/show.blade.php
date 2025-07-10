@extends('layouts.app')

@section('title', $portfolio->title . ' - Sultan Agung Portfolio')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Portfolio Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $portfolio->title }}</h1>
        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 font-medium">← Back to Portfolio</a>
    </div>

    <!-- Portfolio Contents -->
    <div class="space-y-12">
        @foreach($portfolio->contents as $content)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset('storage/' . $content->image_path) }}" 
                         alt="{{ $portfolio->title }}"
                         class="w-full h-96 object-cover">
                </div>
                <div class="p-6">
                    <p class="text-gray-700 text-lg leading-relaxed">{{ $content->description }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Comments Section -->
    <div class="mt-16">
        <h3 class="text-2xl font-bold text-gray-900 mb-8">Comments</h3>
        
        @auth
            <!-- Add Comment Form -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <form method="POST" action="{{ route('comment.store', $portfolio->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Add your comment</label>
                        <textarea name="comment" 
                                  id="comment" 
                                  rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Share your thoughts about this portfolio..."
                                  required></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Post Comment</button>
                </form>
            </div>
        @else
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-center">
                <p class="text-gray-600 mb-4">Please login to leave a comment</p>
                <a href="{{ route('login') }}" class="btn-primary mr-4">Login</a>
                <a href="{{ route('register') }}" class="btn-secondary">Register</a>
            </div>
        @endauth

        <!-- Comments List -->
        <div class="space-y-6">
            @forelse($portfolio->comments as $comment)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($comment->user->username, 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $comment->user->username }}</p>
                            <p class="text-sm text-gray-500">{{ $comment->created_at->format('M d, Y at h:i A') }}</p>
                        </div>
                    </div>
                    <p class="text-gray-700 leading-relaxed">{{ $comment->comment }}</p>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-gray-500">No comments yet. Be the first to comment!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection