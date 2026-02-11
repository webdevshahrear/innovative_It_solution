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

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->siteName = SiteSetting::where('setting_key', 'site_name')->value('setting_value') ?? 'WebBoost Lab';
        $this->logo = SiteSetting::where('setting_key', 'site_logo')->value('setting_value');
        $this->logoWidth = SiteSetting::where('setting_key', 'logo_width')->value('setting_value') ?? 150;
        $this->logoHeight = SiteSetting::where('setting_key', 'logo_height')->value('setting_value') ?? 50;
        $this->contactEmail = SiteSetting::where('setting_key', 'contact_email')->value('setting_value') ?? 'hello@webboost.tech';
        $this->contactPhone = SiteSetting::where('setting_key', 'contact_phone')->value('setting_value') ?? '+880 1736 111122';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return \view('components.header');
    }
}
