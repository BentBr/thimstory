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

                        <h1>home</h1>
                        <h2>featured users</h2>
                        @if(count($users))
                            @foreach($users as $user)
                                <a href="/{{ $user->url_name }}">{{ $user->name }}</a>
                                <br>
                                Views: {{ $user->views }}
                                <br>
                                Stories: {{ count($user->stories) }}
                                <br><br>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
@endsection
