@extends('emails.layouts.email')

@section('content')

    login mail
    <br>

    @component('mail::button', [
    'url' => url('/login/' . $user->login_token)
    ])
        Login!
    @endcomponent

@endsection
