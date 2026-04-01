<?php

declare(strict_types=1);

namespace Digihood\Branding\Modules\Branding;

class AdminColorScheme
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'registerScheme']);
        add_filter('get_user_option_admin_color', [$this, 'forceDefaultScheme']);
    }

    public function registerScheme(): void
    {
        wp_admin_css_color(
            'digihood',
            'digihood',
            D1G1_URL_digibrand . 'assets/css/admin-color-scheme.css',
            ['#1a1a1a', '#2a2a2a', '#ff817e', '#f4f4f4'],
            [
                'base' => '#cccccc',
                'focus' => '#ffffff',
                'current' => '#ffffff',
            ]
        );
    }

    public function forceDefaultScheme(string $color): string
    {
        // Only override if user hasn't explicitly chosen something else
        // On first load or for new users, default to digihood
        if ($color === 'fresh' || $color === '') {
            return 'digihood';
        }
        return $color;
    }
}
