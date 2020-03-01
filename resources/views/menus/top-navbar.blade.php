<navigation-drawer-component></navigation-drawer-component>

<toolbar-component
    :company="'@lang('content.meta.company')'"
    @auth()
        :avatar-url="'{{ Auth::user()->getAvatarUrl() }}'"
        :alt-text="'{{ Auth::user()->getName() }}'"
        :login="true"
        :profile-url="'{{ route('profile', Auth::user()->getUrlName()) }}'"
        :logout-url="'{{ route('logout') }}'"
        :profile-name="'@lang('navigation.profile')'"
        :logout-name="'@lang('auth.logout.logout')'"
    @endauth
    @guest()
        :alt-text="'@lang('auth.login.login')'"
    @endguest
>
</toolbar-component>

