@props(['article', 'isFavorited', 'favoritesCount'])

<div x-data="{
    favorited: {{ $isFavorited ? 'true' : 'false' }},
    count: {{ $favoritesCount }},
    toggleFavorite() {
        fetch(`{{ route('articles.favorite.toggle', $article) }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            this.favorited = data.favorited;
            this.count = data.count;
        });
    }
}">
    <button
        type="button"
        @click="toggleFavorite()"
        :class="favorited ? 'text-red-500' : 'text-gray-400'"
        class="flex items-center gap-1"
    >
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.653 16.915l-.005-.003-.019-.01a20.759 20.759 0 01-1.162-.682 22.045 22.045 0 01-2.582-1.9C4.045 12.733 2 10.352 2 7.5 2 5.015 3.987 3 6.5 3c1.746 0 3.264 1.017 4 2.542C11.236 4.017 12.754 3 14.5 3 17.013 3 19 5.015 19 7.5c0 2.852-2.045 5.233-3.885 6.82a22.048 22.048 0 01-3.744 2.582l-.019.01-.005.003-.002.001a.75.75 0 01-.69 0l-.002-.001z" />
        </svg>
        <span x-text="count"></span>
    </button>
</div>