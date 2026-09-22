<div x-data="{
    favorited: {{ $isFavorited ? 'true' : 'false' }},
    count: {{ $favoritesCount }},
    toggleFavorite() {
        fetch(`/articles/{{ $article->id }}/favorite`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
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
        @click="toggleFavorite()"
        :class="favorited ? 'text-red-500' : 'text-gray-400'"
        class="flex items-center gap-1"
    >
        <svg class="w-6 h-6" fill="currentColor">...</svg>
        <span x-text="count"></span>
    </button>
</div