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
                            <strong>Story Name</strong> {{ $story->name }}
                            <br>
                            @if(count($storyDetails))
                                <h3>These are the story details</h3>
                                @foreach($storyDetails as $storyDetail)
                                <a href="/{{ $user->url_name }}/{{ $story->url_name }}/{{ $storyDetail->story_counter }}">{{ $storyDetail->story_counter }}</a>
                                @endforeach
                            @else
                                <span>No details here!</span>
                            @endif
                            <br>
                            <br>
                        @endif

                        <br><br>
                        <h2>Change Story</h2>
                        <form method="POST" action="{{ route('patchStory') }}">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="text" name="name" id="name" placeholder="Storyname">
                            <input type="hidden" name="storyToBeUpdated" value="{{ $story->id }}">
                            <br>
                            <button type="submit" class="btn btn-primary">
                                Update!
                            </button>
                        </form>
                        <br><br>
                        <h2>!!Delete Story!!</h2>
                        <form method="POST" action="{{ route('deleteStory') }}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="storyToBeDeleted" value="{{ $story->id }}">
                            <br>
                            <button type="submit" class="btn btn-primary">
                                !!!Delete!!!
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
@endsection
