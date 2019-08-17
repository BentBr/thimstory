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

                        <h2>Details of one Story, Story overview</h2>
                        @if(isset($story))
                            {{ $story->name }}
                            <br>
                            {{ $story->id }}
                            @if(isset($storyDetails))
                                <h3>These are the story details</h3>
                                @foreach($storyDetails as $storyDetail)
                                <a href="/{{ $user->url_name }}/{{ $story->url_name }}/{{ $storyDetail->story_counter }}">{{ $storyDetail->story_counter }}</a>

                                @endforeach
                            @endif
                            <br>
                            <br>
                        @endif



                    </div>
                </div>
            </div>
        </div>
@endsection
