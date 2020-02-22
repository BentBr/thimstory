<add-story-detail-component
    :select-label="'@lang('content.stories.select-story')'"
    :select-items="[
    @foreach(Auth::user()->getAllUsersStoriesSorted() as $story)
        {text: '{{ $story->name }}',
        value: '{{ $story->id }}'},
    @endforeach]"
    :file-label="'some'"
    :CSRF-token="'{{ csrf_token() }}'"
    :maxSize="1024"
    >
</add-story-detail-component>

