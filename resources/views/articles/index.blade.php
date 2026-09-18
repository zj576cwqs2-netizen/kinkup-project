<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold">Articles</h1>
                <a href="{{ route('articles.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-md">
                    新規投稿
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($articles as $article)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        @if($article->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $article->images->first()->image_path) }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-48 object-cover rounded">
                        @endif

                        <h2 class="text-xl font-bold mt-4">{{ $article->title }}</h2>
                        <p class="text-gray-600 mt-2">{{ Str::limit($article->content, 100) }}</p>

                        <div class="mt-4">
                            <a href="{{ route('articles.show', $article) }}" class="text-blue-600">詳細を見る</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>