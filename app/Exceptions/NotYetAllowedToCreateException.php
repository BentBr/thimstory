<?php

namespace thimstory\Exceptions;

use Exception;

class NotYetAllowedToCreateException extends Exception
{
    function render()
    {
        return redirect(Route('home'))->withErrors( 'Not yet allowed');
    }
}
