@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="flex-center position-ref full-height">
                    {{ $user->getName() }}
                    <br>
                    {{ $user->email }}

                    <br>
                    <br>
                    @auth()
                        @if(Auth::user()->id != $user->id)
                            <h2>Subscribe this user</h2>

                            <form method="POST" action="{{ route('putUserSubscription') }}">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="subscribed_user_id" value="{{ $user->id }}">
                                <input type="hidden" name="location_redirect" value="/{{ $user->getUrlName() }}">
                                <br>
                                @if(is_null($userSubscribed))
                                    <button type="submit" class="btn btn-primary"><span style="color:mediumblue">Subscribe</span></button>

                                @else
                                    <button type="submit" class="btn btn-primary"><span style="color:darkred">Unsubscribe</span></button>

                                @endif

                            </form>
                        @endif
                    @endauth
                    <br>
                    <br>
                    <div class="content">
                        <div class="title m-b-md">
                            This is {{ Route::currentRouteName() }} path
                        </div>
                        <h2>Change data</h2>
                        <form method="POST" action="{{ route('patchUser') }}">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="text" name="name" id="name" value="{{ $user->getName() }}">
                            <input type="email" name="email" id="email" value="{{ $user->email }}">
                            <br>
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </form>

                        <h2>!!Delete User!!</h2>
                        <form method="POST" action="{{ route('sendDeleteVerificationMail') }}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-primary">
                                Delete Forever
                            </button>
                        </form>

                        <h2>User Stories</h2>
                        @if(isset($stories))
                            @foreach($stories as $story)
                                <a href="/{{ $user->getUrlName() }}/{{ $story->url_name }}">
                                    {{ $story->name }}
                                </a><br>
                            @endforeach
                        @endif
                            <br>

                        <h2>User Subs</h2>
                        @if(! is_null($subscriptions))
                            @if(count($subscriptions['userSubscriptions']))
                                <strong>User subs</strong><br>
                                @foreach($subscriptions['userSubscriptions'] as $userSubscription)
                                    <a href="/{{ $userSubscription->subscribedUser->getUrlName() }}">
                                        {{ $userSubscription->subscribedUser->getName() }}
                                    </a><br>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection
