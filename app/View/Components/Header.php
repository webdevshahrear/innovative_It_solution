<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\SiteSetting;

class Header extends Component
{
    public $siteName;
    public $logo;
    public $logoWidth;
    public $logoHeight;
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
        $this->siteName = SiteSetting::getValue('site_title', 'Innovative IT Solutions');
        $this->logo = SiteSetting::getValue('site_logo');
        $logoWidth = SiteSetting::getValue('logo_width', 180);
        $this->logoWidth = empty($logoWidth) ? 180 : $logoWidth;
        
        $logoHeight = SiteSetting::getValue('logo_height', 60);
        $this->logoHeight = empty($logoHeight) ? 60 : $logoHeight;
        $this->contactEmail = SiteSetting::getValue('contact_email', 'hello@innovativeitsolutions.com');
        $this->contactPhone = SiteSetting::getValue('contact_phone', '+880 1736 111122');
        $this->facebookUrl = SiteSetting::getValue('social_facebook', '#');
        $this->twitterUrl = SiteSetting::getValue('social_twitter', '#');
        $this->linkedinUrl = SiteSetting::getValue('social_linkedin', '#');
        $this->instagramUrl = SiteSetting::getValue('social_instagram', '#');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return \view('components.header');
    }
}
