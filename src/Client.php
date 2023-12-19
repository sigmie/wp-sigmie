<?php

declare(strict_types=1);

namespace Sigmie\WordPressSigmie;

use Sigmie_Plugin;

class Client
{
    protected static $plugin;

    public static function boot()
    {
        static::$plugin = new Sigmie_Plugin;
        static::$plugin->run();
    }

    protected static function isProduction(): bool
    {
        if (!defined('WP_ENVIRONMENT_TYPE')) {
            return false;
        }

        return wp_get_environment_type() === 'production';
    }
}
