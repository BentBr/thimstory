<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@lang('content.meta.company')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <?php //@include('layouts.matomo-header')?>
</head>
<body>
    @include('layouts.matomo-body')
    <v-app id="app">

        @include('menus.top-navbar')
        <v-content>
            <v-container class="fill-height" fluid>
                    <v-row>

                    @auth()
                        <span>Welcome {{ Auth::user()->name }}, you are logged in!</span>
                        <v-list>
                            <v-list-item>
                                <v-list-item-title><a href="/{{ Auth()->user()->url_name }}">{{ Auth()->user()->name }}</a></v-list-item-title>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-title><a href="/{{ Auth()->user()->url_name }}/stories">All Stories</a></v-list-item-title>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-title><a href="{{ Route('logout')  }}">Logout!</a></v-list-item-title>
                            </v-list-item>
                            @if(is_null(Auth()->user()->getDateForNextStory()))
                                <v-list-item>
                                    <v-list-item-title>You can add a new Story!</v-list-item-title>
                                </v-list-item>
                            @else
                                <v-list-item>
                                    <v-list-item-title>You can add a new Story soon: {{ Auth()->user()->getDateForNextStory() }}</v-list-item-title>
                                </v-list-item>
                            @endif
                            @if(is_null(Auth()->user()->getDateForNextStoryDetail()))
                                <v-list-item>
                                    <v-list-item-title>You can add a new Detail!</v-list-item-title>
                                </v-list-item>
                            @else
                                <v-list-item>
                                    <v-list-item-title>You can add a new Story Detail soon: {{ Auth()->user()->getDateForNextStoryDetail() }}</v-list-item-title>
                                </v-list-item>
                            @endif
                        </v-list>
                    @endauth
                    @guest
                        <span>You are NOT logged in!</span>
                        <v-list>
                            <v-list-item>
                                <v-list-item-title><a href="{{ Route('login') }}">Login</a></v-list-item-title>
                            </v-list-item>
                        </v-list>
                    @endguest
                    @yield('content')
                    </v-row>
            </v-container>
        </v-content>

        @auth()
            @if(is_null($newStoryDetail))
                <!-- include of new story detail overlay if logged in and eligible -->
                @include('stories.add-story-detail')
            @endif
                <!-- include profile overlay if logged in -->
                @include('users.profile-detail')
        @endauth

        @guest()
            <!-- include login overlay if not logged in -->
            @include('users.login-overlay')
        @endguest


        <!-- include of footer element -->
        @include('menus.footer')
    </v-app>
</body>
</html>
