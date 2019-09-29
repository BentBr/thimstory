<footer-component :navigation="[
    {name: 'home',
    icon: 'mdi-home',
    text: '@lang('navigation.home')',
    target: '{{ Route('home') }}'},

    {name: 'imprint',
    icon: 'mdi-format-section',
    text: '@lang('navigation.imprint')',
    target: '{{ Route('imprint') }}'},

    {name: 'about',
    icon:
    'mdi-cow', text: '@lang('navigation.about')',
    target: '{{ Route('about') }}'},

    {name: 'privacyPolicy',
    icon: 'mdi-fingerprint',
    text: '@lang('navigation.privacy-policy')',
    target: '{{ Route('privacy-policy') }}'}]"

    :company="'@lang('content.meta.company')'"
></footer-component>
