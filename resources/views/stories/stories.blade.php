@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="flex-center position-ref full-height">

                    <div class="content">
                        <div class="title m-b-md">
                            This is {{ Route::currentRouteName() }} path
                        </div>

                        <a href="/{{ rawurlencode($user->name) }}">{{ $user->name }}</a>
                        <h2>Stories</h2>
                        @if(isset($stories))
                            @foreach($stories as $story)
                                <a href="/{{ $user->url_name }}/{{ $story->url_name }}">{{ $story->name }}</a>
                                <br>
                                {{ $story->id }}

                                <br>
                                <br>
                            @endforeach
                        @else
                            <span>no stories here!</span>
                        @endif
                        @auth()
                            @if(Auth::user()->id != $user->id)
                                <h2>Subscribe!!</h2>

                                <form method="POST" action="{{ route('putUserSubscription') }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="subscribed_user_id" value="{{ $user->id }}">
                                    <input type="hidden" name="location_redirect" value="/{{ $user->url_name . '/stories' }}">
                                    <br>
                                    @if(is_null($userSubscribed))
                                        <button type="submit" class="btn btn-primary"><span style="color:mediumblue">Subscribe</span></button>

                                    @else
                                        <button type="submit" class="btn btn-primary"><span style="color:darkred">Unsubscribe</span></button>

                                    @endif

                                </form>
                            @endif
                        @endauth

                        <br><br>
                        <h2>Create a new Story</h2>
                        <form method="POST" action="{{ route('putStory') }}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="text" name="name" id="name" placeholder="Storyname">
                            <br>
                            <button type="submit" class="btn btn-primary">
                                Create!
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
