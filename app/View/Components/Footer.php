<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\SiteSetting;

class Footer extends Component
{
    public $siteName;
    public $siteLogo;
    public $footerLogo;
    public $contactEmail;
    public $contactPhone;
    public $facebookUrl;
    public $twitterUrl;
    public $linkedinUrl;
    public $instagramUrl;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->siteName = SiteSetting::where('setting_key', 'site_name')->value('setting_value') ?? 'WebBoost Lab';
        $this->siteLogo = SiteSetting::where('setting_key', 'site_logo')->value('setting_value');
        $this->footerLogo = SiteSetting::where('setting_key', 'footer_logo')->value('setting_value');
        $this->contactEmail = SiteSetting::where('setting_key', 'contact_email')->value('setting_value') ?? 'hello@webboost.tech';
        $this->contactPhone = SiteSetting::where('setting_key', 'contact_phone')->value('setting_value') ?? '+880 1736 111122';
        $this->facebookUrl = SiteSetting::where('setting_key', 'facebook_url')->value('setting_value') ?? '#';
        $this->twitterUrl = SiteSetting::where('setting_key', 'twitter_url')->value('setting_value') ?? '#';
        $this->linkedinUrl = SiteSetting::where('setting_key', 'linkedin_url')->value('setting_value') ?? '#';
        $this->instagramUrl = SiteSetting::where('setting_key', 'instagram_url')->value('setting_value') ?? '#';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return \view('components.footer');
    }
}
