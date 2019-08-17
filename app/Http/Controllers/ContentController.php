<?php

namespace thimstory\Http\Controllers;

class ContentController extends Controller
{
    public function home()
    {
        return view('content/home');
    }

    public function imprint()
    {
        return view('content/imprint');
    }

    public function privacyPolicy()
    {
        return view('content/privacy-policy');
    }

    public function about()
    {
        return view('content/about');
    }
}
