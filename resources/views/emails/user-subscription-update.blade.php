@extends('emails.layouts.email')

@section('content')

    register mail
    <br>

    @component('mail::button', [
    'url' => url('/login/' . $user->remember_token)
    ])
        Register!
    @endcomponent

@endsection