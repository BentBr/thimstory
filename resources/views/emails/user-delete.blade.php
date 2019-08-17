@extends('emails.layouts.email')

@section('content')

    delete mail
    <br>

    @component('mail::button', [
    'url' => url('/login/' . $user->remember_token)
    ])
        Register!
    @endcomponent

@endsection