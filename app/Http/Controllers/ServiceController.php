<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\SiteSetting;

class ServiceController extends Controller
{
    public function index()
    {
        $pageTitle = 'Our Services - ' . SiteSetting::getValue('site_title', 'Innovative IT Solutions');
        $services = Service::where('status', 'active')->orderBy('display_order')->get();
        return \view('services', compact('pageTitle', 'services'));
    }
}
