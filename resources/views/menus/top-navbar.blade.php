
<nav>
    <a href="{{ Route('home') }}">Home</a>
    <a href="{{ Route('imprint') }}">Imprint</a>
    <a href="{{ Route('about') }}">About</a>
    <a href="{{ Route('privacy-policy') }}">Privacy Policy</a>
</nav>
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
