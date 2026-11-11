<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\Alert;
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Alert\DefaultTest;

/**
 * Provides the variant, fixed expected markup, and deferred builders for {@see DefaultTest}.
 */
final class AlertDefaultProvider
{
    /**
     * @return array<string, array{string, string, Closure(): string}>
     */
    public static function danger(): array
    {
        return [
            'Bootstrap 5' => [
                'danger',
                <<<HTML
                    <div class="alert alert-danger" id="alert_658fec01ac6cf" role="alert">
                    A simple danger alert—check it out!
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->content('A simple danger alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'danger'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'danger',
                <<<HTML
                    <div class="alert theme-danger" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    A simple danger alert—check it out!
                    </div>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->content('A simple danger alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'danger'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
        ];
    }

    /**
     * @return array<string, array{string, string, Closure(): string}>
     */
    public static function dark(): array
    {
        return [
            'Bootstrap 5' => [
                'dark',
                <<<HTML
                    <div class="alert alert-dark" id="alert_658fec01ac6cf" role="alert">
                    A simple dark alert—check it out!
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->content('A simple dark alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'dark'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'dark',
                <<<HTML
                    <div id="alert_658fec01ac6cf" role="alert">
                    A simple dark alert—check it out!
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->content('A simple dark alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'dark'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
        ];
    }

    /**
     * @return array<string, array{string, string, Closure(): string}>
     */
    public static function info(): array
    {
        return [
            'Bootstrap 5' => [
                'info',
                <<<HTML
                    <div class="alert alert-info" id="alert_658fec01ac6cf" role="alert">
                    A simple info alert—check it out!
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->content('A simple info alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'info'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'info',
                <<<HTML
                    <div class="alert theme-info" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    A simple info alert—check it out!
                    </div>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->content('A simple info alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'info'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
        ];
    }

    /**
     * @return array<string, array{string, string, Closure(): string}>
     */
    public static function light(): array
    {
        return [
            'Bootstrap 5' => [
                'light',
                <<<HTML
                    <div class="alert alert-light" id="alert_658fec01ac6cf" role="alert">
                    A simple light alert—check it out!
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->content('A simple light alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'light'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'light',
                <<<HTML
                    <div id="alert_658fec01ac6cf" role="alert">
                    A simple light alert—check it out!
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->content('A simple light alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'light'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
        ];
    }

    /**
     * @return array<string, array{string, string, Closure(): string}>
     */
    public static function primary(): array
    {
        return [
            'Bootstrap 5' => [
                'primary',
                <<<HTML
                    <div class="alert alert-primary" id="alert_658fec01ac6cf" role="alert">
                    A simple primary alert—check it out!
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->content('A simple primary alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'primary'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'primary',
                <<<HTML
                    <div class="alert theme-primary" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    A simple primary alert—check it out!
                    </div>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->content('A simple primary alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'primary'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
        ];
    }

    /**
     * @return array<string, array{string, string, Closure(): string}>
     */
    public static function secondary(): array
    {
        return [
            'Bootstrap 5' => [
                'secondary',
                <<<HTML
                    <div class="alert alert-secondary" id="alert_658fec01ac6cf" role="alert">
                    A simple secondary alert—check it out!
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->content('A simple secondary alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'secondary'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'secondary',
                <<<HTML
                    <div class="alert theme-secondary" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    A simple secondary alert—check it out!
                    </div>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->content('A simple secondary alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'secondary'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
        ];
    }

    /**
     * @return array<string, array{string, string, Closure(): string}>
     */
    public static function success(): array
    {
        return [
            'Bootstrap 5' => [
                'success',
                <<<HTML
                    <div class="alert alert-success" id="alert_658fec01ac6cf" role="alert">
                    A simple success alert—check it out!
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->content('A simple success alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'success'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'success',
                <<<HTML
                    <div class="alert theme-success" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    A simple success alert—check it out!
                    </div>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->content('A simple success alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'success'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
        ];
    }

    /**
     * @return array<string, array{string, string, Closure(): string}>
     */
    public static function warning(): array
    {
        return [
            'Bootstrap 5' => [
                'warning',
                <<<HTML
                    <div class="alert alert-warning" id="alert_658fec01ac6cf" role="alert">
                    A simple warning alert—check it out!
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->content('A simple warning alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'warning'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'warning',
                <<<HTML
                    <div class="alert theme-warning" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    A simple warning alert—check it out!
                    </div>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->content('A simple warning alert—check it out!')
                        ->config($config, new ComponentContext('alert', variant: 'warning'))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
        ];
    }
}
