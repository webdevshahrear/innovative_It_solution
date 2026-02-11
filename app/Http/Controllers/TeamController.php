<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMember;

class TeamController extends Controller
{
    public function index()
    {
        $pageTitle = 'Our Team - WebBoost Lab';
        $teamMembers = TeamMember::where('status', 'active')->orderBy('display_order')->get();
        return \view('team', compact('pageTitle', 'teamMembers'));
    }
}
