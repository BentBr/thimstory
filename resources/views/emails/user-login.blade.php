@extends('emails.layouts.email')

@section('content')

    login mail
    <br>

    @component('mail::button', [
    'url' => url('/login/' . $user->getUserIdAndLoginTokenBase64())
    ])
        Login!
    @endcomponent

@endsection
