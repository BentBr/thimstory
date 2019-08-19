<?php

namespace thimstory\Http\Controllers;

use thimstory\Models\User;

class ContentController extends Controller
{
    public function home()
    {
        $data['users'] = User::getUsersBasedOnViews(10);

        return view('content/home', $data);
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
