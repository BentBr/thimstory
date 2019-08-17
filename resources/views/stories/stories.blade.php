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

                        <h2>Stories</h2>
                        @if(isset($stories))
                            @foreach($stories as $story)
                                {{ $story->name }}
                            <br>
                                {{ $story->id }}
                                <br>
                                <br>
                            @endforeach
                        @endif



                    </div>
                </div>
            </div>
        </div>
@endsection
