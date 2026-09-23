@props(['article'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
    @if ($article->images->isNotEmpty())
        <img src="{{ asset('storage/' . $article->images->first()->image_path) }}"
             alt="{{ $article->title }}"
             class="w-full h-48 object-cover">
    @else
        <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
            No Image
        </div>
    @endif

    <div class="p-4">
        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate">
            {{ $article->title }}
        </h3>

        <p class="text-gray-600 text-sm mb-4">
            {{ Str::limit($article->content, 100) }}
        </p>

        <div class="flex items-center justify-between text-sm text-gray-500">
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1">
                    {{ $article->user->name }}
                </span>

                @if ($article->published_at)
                    <span class="flex items-center gap-1">
                        {{ $article->published_at->format('Y/m/d') }}
                    </span>
                @endif
            </div>

            <a href="{{ route('articles.show', $article) }}"
               class="text-blue-600 hover:text-blue-800 font-medium">
                詳細 &rarr;
            </a>
        </div>

        @if ($article->reviews->isNotEmpty())
            <div class="mt-3 pt-3 border-t flex items-center gap-1 text-sm text-yellow-600">
                {{ str_repeat('★', (int) round($article->reviews->avg('rating'))) }}
                <span class="text-gray-400">({{ $article->reviews->count() }})</span>
            </div>
        @endif
    </div>
</div>