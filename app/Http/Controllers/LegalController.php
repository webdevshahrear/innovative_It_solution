<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function privacy()
    {
        return view('legal.privacy', ['pageTitle' => 'Privacy Policy']);
    }

    public function terms()
    {
        return view('legal.terms', ['pageTitle' => 'Terms of Use']);
    }

    public function help()
    {
        return view('legal.help', ['pageTitle' => 'Help Center']);
    }

    public function sitemap()
    {
        return view('legal.sitemap', ['pageTitle' => 'Sitemap']);
    }
}
