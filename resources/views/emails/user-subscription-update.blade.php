@extends('emails.layouts.email')

@section('content')

    Update  mail
    <br>
    Hi {{ $subscribingUser->name }},<br><br>
    {{ $updatedUser->name }} added
    @if($content == 'newStoryDetail')
        another part of {{ $story->name }}
    @elseif ($content == 'newStory')
        a new Story: {{ $story->name }}
    @else
        {{ $imBreakingHereVariable }}
    @endif

    @component('mail::button', [
    'url' => url('/login/' . $subscribingUser->remember_token)
    ])
        Register!
    @endcomponent

    wanna unsubscribe?
    INSERT LINK HERE
@endsection
