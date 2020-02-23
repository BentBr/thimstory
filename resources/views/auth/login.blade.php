<?php
    $emailName = Lang::get('auth.login.email')
?>
<login-register-component
    :select-label="'@lang('auth.login.email')'"
    :CSRF-token="'{{ csrf_token() }}'"
    :title="'@lang('auth.login.login')'"
    :description-login="'@lang('auth.login.description-login')'"
    :description-register="'@lang('auth.login.description-register')'"
    :email-name="'@lang('auth.login.email')'"
    :email-required-validation="'@lang('validation.email', ['attribute' => $emailName])'"
    :email-valid-validation="'@lang('validation.email-required', ['attribute' => $emailName])'"
    :cancel="'@lang('content.meta.cancel')'"
    :login="'@lang('content.meta.login')'"
>
</login-register-component>
