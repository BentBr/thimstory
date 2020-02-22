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

                        <h2>Story detail</h2>
                        @if(isset($story))
                            {{ $story->name }}
                            <br>
                            {{ $story->id }}
                            <br>
                            <br>
                        @endif

                        <v-img
                                src="/storyDetails/{{ $storyDetail->id }}"
                                aspect-ratio="1"
                                class="grey lighten-2"
                                max-width="500"
                                max-height="300"
                        ></v-img>

                        <h2>Update Detail</h2>
                        <form method="POST" action="{{ route('patchStoryDetails') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="file" name="story_detail" id="story_detail" accept="image/*">
                            <input type="hidden" name="story_detail_id" value="{{ $storyDetail->id }}">
                            <br>
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </form>

                        <br><br>
                        <h2>!!Delete Story Detail!!</h2>
                        <form method="POST" action="{{ route('deleteStoryDetails') }}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="story_detail_to_be_deleted" value="{{ $storyDetail->id }}">
                            <br>
                            <button type="submit" class="btn btn-primary">
                                !!!Delete!!!
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
