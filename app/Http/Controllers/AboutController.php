<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;

class AboutController extends Controller
{
    public function index()
    {
        $pageTitle = 'About Us - ' . SiteSetting::getValue('site_title', 'Innovative IT Solutions');
        return \view('about', compact('pageTitle'));
    }
}
