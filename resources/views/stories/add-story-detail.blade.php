<add-story-detail-component
    :selectlabel="uiaeuae"
    :selectitems="[
    @foreach(Auth::user()->getAllUsersStoriesSorted() as $story)
        {text: '{{ $story->name }}',
        value: '{{ $story->id }}'},
    @endforeach]"
    :filelabel="some"
    :csrftoken="{{ csrf_token() }}"
    :maxSize="1024"
    ></add-story-detail-component>

