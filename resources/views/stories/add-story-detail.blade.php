<add-story-detail-component
    :select-label="'@lang('content.stories.select-story')'"
    :select-items="[
    @foreach(Auth::user()->getAllUsersStoriesSorted() as $story)
        {text: '{{ $story->name }}',
        value: '{{ $story->id }}'},
    @endforeach]"
    :file-label="'some'"
    :csrf-token="'{{ csrf_token() }}'"
    :max-size="1024"
    :route="'{{ route('putStoryDetails') }}'"
    :send-name="'@lang('content.meta.add')'"
    :cancel-name="'@lang('content.meta.cancel')'"
    >
</add-story-detail-component>

