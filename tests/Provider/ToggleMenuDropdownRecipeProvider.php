<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\Toggle;
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Toggle\MenuDropdownRecipeTest;

/**
 * Provides fixed expected markup and deferred builders for {@see MenuDropdownRecipeTest}.
 */
final class ToggleMenuDropdownRecipeProvider
{
    /**
     * @return array<string, array{string, Closure(): string}>
     */
    public static function render(): array
    {
        return [
            'Bootstrap 5 without content' => [
                <<<HTML
                    <a class="nav-link dropdown-toggle" role="button" aria-expanded="false" data-bs-toggle="dropdown">
                    </a>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Toggle::tag()
                        ->config($config, new ComponentContext('toggle', variant: 'menu-dropdown'))
                        ->render();
                },
            ],
            'Bootstrap 5 with content' => [
                <<<HTML
                    <a class="nav-link dropdown-toggle" role="button" aria-expanded="false" data-bs-toggle="dropdown">
                    Docs
                    </a>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Toggle::tag()
                        ->config($config, new ComponentContext('toggle', variant: 'menu-dropdown'))
                        ->content('Docs')
                        ->render();
                },
            ],
            'Bootstrap 6 without content' => [
                <<<HTML
                    <a class="nav-link menu-toggle" role="button" aria-expanded="false" data-bs-toggle="menu">
                    </a>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Toggle::tag()
                        ->config($config, new ComponentContext('toggle', variant: 'menu-dropdown'))
                        ->render();
                },
            ],
            'Bootstrap 6 with content' => [
                <<<HTML
                    <a class="nav-link menu-toggle" role="button" aria-expanded="false" data-bs-toggle="menu">
                    Docs
                    </a>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Toggle::tag()
                        ->config($config, new ComponentContext('toggle', variant: 'menu-dropdown'))
                        ->content('Docs')
                        ->render();
                },
            ],
        ];
    }
}
