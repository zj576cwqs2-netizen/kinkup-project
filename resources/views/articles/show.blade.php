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
        </div>
    </div>
</x-app-layout>