@extends('layouts.app')

@section('title', 'Admin Dashboard - Sultan Agung Portfolio')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <a href="{{ route('admin.create') }}" class="btn-primary">Create New Portfolio</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-8">
            {{ session('success') }}
        </div>
    @endif

    @if($portfolios->isEmpty())
        <div class="text-center py-20">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">No portfolios created yet</h2>
            <p class="text-gray-600 mb-8">Create your first portfolio to get started.</p>
            <a href="{{ route('admin.create') }}" class="btn-primary">Create Portfolio</a>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($portfolios as $portfolio)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    @if($portfolio->contents->first())
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="{{ asset('storage/' . $portfolio->contents->first()->image_path) }}" 
                                 alt="{{ $portfolio->title }}"
                                 class="w-full h-48 object-cover">
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $portfolio->title }}</h3>
                        <p class="text-sm text-gray-600 mb-4">{{ $portfolio->contents->count() }} content(s)</p>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('portfolio.show', $portfolio->id) }}" 
                               class="btn-secondary text-sm">View</a>
                            <a href="{{ route('admin.edit', $portfolio->id) }}" 
                               class="btn-primary text-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.destroy', $portfolio->id) }}" 
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this portfolio?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger text-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection