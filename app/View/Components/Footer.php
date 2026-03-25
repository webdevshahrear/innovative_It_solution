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
    public $footerLogoWidth;
    public $footerLogoHeight;
    public $footerDescription;
    public $footerCopyright;
    public $footerCol1Title;
    public $footerCol2Title;
    public $footerCol3Title;
    public $footerEmailLabel;
    public $footerPhoneLabel;
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
        $this->siteName = SiteSetting::getValue('site_title', 'Innovative It Solutions');
        $this->siteLogo = SiteSetting::getValue('site_logo');
        $this->footerLogo = SiteSetting::getValue('footer_logo');
        $bgLogoW = SiteSetting::getValue('footer_logo_width', 180);
        $this->footerLogoWidth = empty($bgLogoW) ? 180 : $bgLogoW;

        $bgLogoH = SiteSetting::getValue('footer_logo_height', 60);
        $this->footerLogoHeight = empty($bgLogoH) ? 60 : $bgLogoH;
        
        $this->footerDescription = SiteSetting::getValue('footer_description', 'Elevating brands through high-impact design and innovative technology. We create digital experiences that resonate on a global scale.');
        $this->footerCopyright = SiteSetting::getValue('footer_copyright', 'Crafted with Precision & <i class="fas fa-heart"></i> by Innovative It Solutions.');
        
        $this->footerCol1Title = SiteSetting::getValue('footer_col1_title', 'Agency');
        $this->footerCol2Title = SiteSetting::getValue('footer_col2_title', 'Support');
        $this->footerCol3Title = SiteSetting::getValue('footer_col3_title', 'Get In Touch');
        
        $this->footerEmailLabel = SiteSetting::getValue('footer_email_label', 'Email Inquiry');
        $this->footerPhoneLabel = SiteSetting::getValue('footer_phone_label', 'Phone Support');

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
        return \view('components.footer');
    }
}
