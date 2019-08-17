@auth()
    <span>You are logged in!</span>
    <v-list>
        <v-list-item>
            <v-list-item-title><a href="/{{ $user->url_name }}">{{ $user->name }}</a></v-list-item-title>
        </v-list-item>
        <v-list-item>
            <v-list-item-title><a href="/{{ $user->url_name }}/stories">All Stories</a></v-list-item-title>
        </v-list-item>
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
