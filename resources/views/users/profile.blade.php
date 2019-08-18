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
                        <h2>Change data</h2>
                        <form method="POST" action="{{ route('patchUser') }}">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="text" name="name" id="name" value="{{ $user->name }}">
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
