@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="flex-center position-ref full-height">
                    {{ $user->name }}
                    <br>
                    {{ $user->email }}

                    <div class="content">
                        <div class="title m-b-md">
                            This is {{ Route::currentRouteName() }} path
                        </div>

                        <h2>User Stories</h2>
                        @if(isset($stories))
                            @foreach($stories as $story)
                                {{ $story->name }}
                            @endforeach
                        @endif
                            <br>

                        <h2>User Subs</h2>
                        @if(isset($subscriptions))
                            @foreach($subscriptions as $subscription)
                                {{ $subscription->stories->name }}
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection
