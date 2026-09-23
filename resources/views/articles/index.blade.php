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

            <form method="GET" action="{{ route('articles.index') }}"
                  class="bg-white shadow-md rounded-lg p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">キーワード</label>
                    <input id="search" name="search" type="text"
                           value="{{ request('search') }}"
                           placeholder="タイトル・本文"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700">投稿者</label>
                    <input id="author" name="author" type="text"
                           value="{{ request('author') }}"
                           placeholder="投稿者名"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700">投稿日（から）</label>
                    <input id="date_from" name="date_from" type="date"
                           value="{{ request('date_from') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700">投稿日（まで）</label>
                    <input id="date_to" name="date_to" type="date"
                           value="{{ request('date_to') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="md:col-span-4 flex items-center gap-4">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md">
                        検索
                    </button>
                    @if (request()->anyFilled(['search', 'author', 'date_from', 'date_to']))
                        <a href="{{ route('articles.index') }}" class="text-gray-600">
                            条件をクリア
                        </a>
                    @endif
                </div>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($articles as $article)
                    <x-article-card :article="$article" />
                @empty
                    <p class="text-gray-500 col-span-full">
                        @if (request()->anyFilled(['search', 'author', 'date_from', 'date_to']))
                            条件に一致する記事がありません。
                        @else
                            まだ記事がありません。
                        @endif
                    </p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>