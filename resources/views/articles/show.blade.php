<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            記事詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                @if ($article->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $article->images->first()->image_path) }}"
                         alt="{{ $article->title }}"
                         class="w-full h-64 object-cover rounded mb-6">
                @endif

                <div class="flex items-center justify-between mb-2">
                    <h1 class="text-2xl font-bold">{{ $article->title }}</h1>
                    @if ($article->status === 'draft')
                        <span class="text-sm bg-gray-200 text-gray-700 px-2 py-1 rounded">下書き</span>
                    @endif
                </div>

                <div class="mb-4">
                    <x-favorite-button
                        :article="$article"
                        :is-favorited="$isFavorited"
                        :favorites-count="$favoritesCount"
                    />
                </div>

                <p class="text-sm text-gray-500 mb-6">
                    {{ $article->user->name }} ・
                    {{ optional($article->published_at)->format('Y年m月d日') ?? '未公開' }}
                </p>

                <div class="prose max-w-none whitespace-pre-line mb-8">
                    {{ $article->content }}
                </div>

                @if (Auth::id() === $article->user_id)
                    <div class="flex items-center gap-4 pt-4 border-t">
                        <a href="{{ route('articles.edit', $article) }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-md">
                            編集する
                        </a>

                        <form method="POST" action="{{ route('articles.destroy', $article) }}"
                              onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md">
                                削除する
                            </button>
                        </form>
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('articles.index') }}" class="text-gray-600">
                        &laquo; 一覧に戻る
                    </a>
                </div>

            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-6">
                <h2 class="text-xl font-bold mb-4">レビュー（{{ $article->reviews->count() }}件）</h2>

                @forelse ($article->reviews as $review)
                    <div class="border-b py-4">
                        <div class="flex items-center gap-2">
                            <span class="text-yellow-500">
                                {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                            </span>
                            <span class="text-sm text-gray-500">{{ $review->user->name }}</span>
                        </div>
                        <p class="mt-2 text-gray-700 whitespace-pre-line">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">まだレビューがありません。</p>
                @endforelse

                @auth
                    <form method="POST" action="{{ route('articles.reviews.store', $article) }}" class="mt-6">
                        @csrf

                        <div class="mb-4">
                            <label for="rating" class="block text-sm font-medium text-gray-700">評価</label>
                            <select id="rating" name="rating"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ str_repeat('★', $i) }}（{{ $i }}）</option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700">コメント</label>
                            <textarea id="comment" name="comment" rows="4"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                      required maxlength="500"></textarea>
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                            レビューを投稿する
                        </button>
                    </form>
                @endauth
            </div>

        </div>
    </div>
</x-app-layout>