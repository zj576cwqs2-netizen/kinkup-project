<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            閲覧履歴
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg divide-y">
                @forelse ($histories as $history)
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <a href="{{ route('articles.show', $history->article) }}"
                               class="text-lg font-medium text-blue-600 hover:underline">
                                {{ $history->article->title }}
                            </a>
                            <p class="text-sm text-gray-500">
                                {{ $history->article->user->name }}
                            </p>
                        </div>
                        <span class="text-sm text-gray-400">
                            {{ $history->viewed_at->format('Y/m/d H:i') }} 閲覧
                        </span>
                    </div>
                @empty
                    <p class="p-4 text-gray-500">まだ閲覧履歴がありません。</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $histories->links() }}
            </div>
        </div>
    </div>
</x-app-layout>