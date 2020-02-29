<navigation-drawer-component></navigation-drawer-component>

<toolbar-component
    :company="'@lang('content.meta.company')'"
    @auth()
        :avatar-url="'{{ Auth::user()->getAvatarUrl() }}'"
        :alt-text="'{{ Auth::user()->name }}'"
        :login="true"
    @endauth
    @guest()
        :alt-text="'@lang('auth.login.login')'"
    @endguest
>
</toolbar-component>

