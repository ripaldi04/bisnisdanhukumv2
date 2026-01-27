@extends('layout')

@include('components.navbar')
@section('content')
    <div class="container mx-auto px-6 lg:px-20 py-16">

        <!-- Search Input -->
        <div class="mb-6">
            <form method="GET" action="{{ route('articles.index') }}">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari artikel berdasarkan judul..."
                    class="w-full p-3 border rounded-lg shadow-sm focus:ring focus:ring-yellow-300">
            </form>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Column: Latest Articles -->
            <div class="md:col-span-2">
                <h2 class="text-2xl font-bold mb-4">Artikel Terbaru</h2>
                <div class="space-y-4">
                    @forelse ($latestArticles as $article)
                        <div class="flex gap-4 border-b pb-4">
                            <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}"
                                class="w-1/4 object-cover rounded">
                            <div>
                                <a href="{{ route('articles.show', $article->slug) }}"
                                    class="text-black text-xl font-semibold hover:underline">
                                    {{ $article->title }}
                                </a>
                                <p class="text-sm text-gray-500">{{ $article->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada artikel terbaru.</p>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $latestArticles->links() }}
                </div>
            </div>

            <!-- Right Column: Most Viewed Articles -->
            <div>
                <h2 class="text-2xl font-bold mb-4">Artikel Terpopuler</h2>
                <div class="space-y-4">
                    @forelse ($mostViewedArticles as $article)
                        <div class="flex items-center gap-4 border-b pb-4">
                            <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}"
                                class="w-16 h-16 object-cover rounded">
                            <div>
                                <a href="{{ route('articles.show', $article->slug) }}"
                                    class="text-black font-semibold hover:underline">
                                    {{ $article->title }}
                                </a>
                                <p class="text-sm text-gray-500">{{ $article->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada artikel terpopuler.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
