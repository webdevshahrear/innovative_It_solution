<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $pageTitle = 'Our Services - WebBoost Lab';
        $services = Service::where('status', 'active')->orderBy('display_order')->get();
        return \view('services', compact('pageTitle', 'services'));
    }
}
