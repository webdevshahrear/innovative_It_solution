<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMember;
use App\Models\SiteSetting;

class TeamController extends Controller
{
    public function index()
    {
        $pageTitle = 'Our Team - ' . SiteSetting::getValue('site_title', 'Innovative IT Solutions');
        $teamMembers = TeamMember::where('status', '=', 'active')->orderBy('display_order')->get();
        return \view('team', compact('pageTitle', 'teamMembers'));
    }

    public function show($id)
    {
        $member = TeamMember::findOrFail($id);
        $pageTitle = $member->name . ' - ' . SiteSetting::getValue('site_title', 'Innovative IT Solutions');
        return \view('team.show', compact('pageTitle', 'member'));
    }
}
