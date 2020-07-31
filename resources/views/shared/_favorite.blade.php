<a title="Click to mask as favorite question (click again to undo)"
    class="favorite mt-2  {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}"
    onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $model->id }}').submit()">
    <i class="fas fa-star fa-2x"></i>
</a>
<form id="favorite-question-{{ $model->id }}" method="POST" style="display:none;"
    action="/questions/{{ $model->id }}/favorites">
    @if($model->is_favorited)
        @method('DELETE')
    @endif
    @csrf
</form>
<span class="favorite-count">{{ $model->favorites_count }}</span>
