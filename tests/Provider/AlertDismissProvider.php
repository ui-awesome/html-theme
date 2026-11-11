<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\Alert;
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Alert\DismissTest;

/**
 * Provides the variant, fixed expected markup, and deferred builders for {@see DismissTest}.
 */
final class AlertDismissProvider
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
                    <div class="alert alert-danger alert-dismissible fade show" id="alert_658fec01ac6cf" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'danger', states: ['dismissible']))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'danger',
                <<<HTML
                    <div class="alert theme-danger" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    </div>
                    <button class="btn-close ms-auto" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'danger', states: ['dismissible']))
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
                    <div class="alert alert-dark alert-dismissible fade show" id="alert_658fec01ac6cf" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'dark', states: ['dismissible']))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'dark',
                <<<HTML
                    <div id="alert_658fec01ac6cf" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'dark', states: ['dismissible']))
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
                    <div class="alert alert-info alert-dismissible fade show" id="alert_658fec01ac6cf" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'info', states: ['dismissible']))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'info',
                <<<HTML
                    <div class="alert theme-info" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    </div>
                    <button class="btn-close ms-auto" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'info', states: ['dismissible']))
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
                    <div class="alert alert-light alert-dismissible fade show" id="alert_658fec01ac6cf" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'light', states: ['dismissible']))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'light',
                <<<HTML
                    <div id="alert_658fec01ac6cf" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'light', states: ['dismissible']))
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
                    <div class="alert alert-primary alert-dismissible fade show" id="alert_658fec01ac6cf" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'primary', states: ['dismissible']))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'primary',
                <<<HTML
                    <div class="alert theme-primary" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    </div>
                    <button class="btn-close ms-auto" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'primary', states: ['dismissible']))
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
                    <div class="alert alert-secondary alert-dismissible fade show" id="alert_658fec01ac6cf" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'secondary', states: ['dismissible']))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'secondary',
                <<<HTML
                    <div class="alert theme-secondary" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    </div>
                    <button class="btn-close ms-auto" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'secondary', states: ['dismissible']))
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
                    <div class="alert alert-success alert-dismissible fade show" id="alert_658fec01ac6cf" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'success', states: ['dismissible']))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'success',
                <<<HTML
                    <div class="alert theme-success" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    </div>
                    <button class="btn-close ms-auto" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'success', states: ['dismissible']))
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
                    <div class="alert alert-warning alert-dismissible fade show" id="alert_658fec01ac6cf" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'warning', states: ['dismissible']))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                'warning',
                <<<HTML
                    <div class="alert theme-warning" id="alert_658fec01ac6cf" role="alert">
                    <div>
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    </div>
                    <button class="btn-close ms-auto" type="button" aria-label="Close" data-bs-dismiss="alert">
                    </button>
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Alert::tag()
                        ->html('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                        ->config($config, new ComponentContext('alert', variant: 'warning', states: ['dismissible']))
                        ->id('alert_658fec01ac6cf')
                        ->render();
                },
            ],
        ];
    }
}
