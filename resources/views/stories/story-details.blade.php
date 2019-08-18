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
                    </div>
                </div>
            </div>
        </div>
@endsection
