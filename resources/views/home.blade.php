@extends('layouts.app')

@section('title', 'Sultan Agung Portfolio')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if($portfolios->isEmpty())
        <div class="text-center py-20">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to Sultan Agung Portfolio</h1>
            <p class="text-xl text-gray-600 mb-8">No portfolios available yet. Please check back later.</p>
            @if(auth()->check() && auth()->user()->is_admin)
                <a href="{{ route('admin.create') }}" class="btn-primary">Create First Portfolio</a>
            @endif
        </div>
    @else
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Portfolio</h1>
            <p class="text-xl text-gray-600">Silahkan lihat portfolio kami dibawah ini!</p>
        </div>
        
        <div class="portfolio-grid">
            @foreach($portfolios as $portfolio)
                <div class="portfolio-card" 
                     data-title="{{ $portfolio->title }}"
                     data-image="{{ $portfolio->firstContent ? asset('storage/' . $portfolio->firstContent->image_path) : '' }}"
                     onclick="window.location.href='{{ route('portfolio.show', $portfolio->id) }}'">
                    @if($portfolio->firstContent)
                        <img src="{{ asset('storage/' . $portfolio->firstContent->image_path) }}" 
                             alt="{{ $portfolio->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-500">
                            <span class="text-lg font-medium">{{ $portfolio->title }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection