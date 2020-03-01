@extends('emails.layouts.email')

@section('content')

    delete mail
    <br>

    @component('mail::button', [
    'url' => url('/user/delete/' . $user->login_token)
    ])
        Delete!
    @endcomponent

@endsection

