<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            記事を投稿
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block font-medium text-sm text-gray-700">タイトル</label>
                        <input id="title" name="title" type="text"
                               value="{{ old('title') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                               required maxlength="200">
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block font-medium text-sm text-gray-700">本文</label>
                        <textarea id="content" name="content" rows="10"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                  required>{{ old('content') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block font-medium text-sm text-gray-700">画像（任意・5MBまで）</label>
                        <input id="image" name="image" type="file" accept="image/*"
                               class="mt-1 block w-full">
                    </div>

                    <div class="mb-6">
                        <label for="status" class="block font-medium text-sm text-gray-700">公開状態</label>
                        <select id="status" name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                                下書き保存
                            </option>
                            <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>
                                公開する
                            </option>
                        </select>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md">
                            投稿する
                        </button>
                        <a href="{{ route('articles.index') }}" class="text-gray-600">
                            キャンセル
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>