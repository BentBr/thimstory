@extends('emails.layouts.email')

@section('content')

    register mail
    <br>

    @component('mail::button', [
    'url' => url('/login/' . $user->getUserIdAndLoginTokenBase64())
    ])
        Register!
    @endcomponent

@endsection
