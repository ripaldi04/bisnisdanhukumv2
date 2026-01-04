@extends('layout')

@include('components.navbar')
@section('content')
    <div class="container mx-auto px-6 lg:px-20 py-16">
        <div class="max-w-3xl mx-auto">
            <div class="flex items-center space-x-5 mb-4">
                <a href="{{ route('category', $article->category->slug) }}"
                    class="p-2 rounded-2xl bg-[#f1f1fc] text-black">{{ $article->category->name }}</a>
                <p class="text-black font-bold">Updated {{ $article->updated_at->format('d M Y') }}</p>
            </div>
            <p class="text-5xl font-bold mb-2 text-black">{{ $article->title }}</p>
            <div class="prose">{!! $article->content !!}</div>
        </div>
    </div>
@endsection
