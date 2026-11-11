<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\{Dropdown, Item, Menu, NavBar};
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Toggle\MenuDropdownTest;

/**
 * Provides fixed expected markup and deferred builders for {@see MenuDropdownTest}.
 */
final class ToggleMenuDropdownProvider
{
    /**
     * @return array<string, array{string, Closure(): string}>
     */
    public static function render(): array
    {
        return [
            'Bootstrap 5' => [
                <<<HTML
                    <a class="nav-link dropdown-toggle" role="button" aria-expanded="false" data-bs-toggle="dropdown">
                    Dropdown
                    </a>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5Theme());

                    return NavBar::tag()
                        ->config($config, new ComponentContext('navbar'))
                        ->menu(
                            Menu::tag()
                                ->id('test-menu')
                                ->items(
                                    Dropdown::tag()
                                        ->containerTag(false)
                                        ->id(null)
                                        ->items(
                                            Item::tag()
                                                ->label('Action')
                                                ->link('#')
                                        )
                                )
                        )
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                <<<HTML
                    <a class="nav-link menu-toggle" role="button" aria-expanded="false" data-bs-toggle="menu">
                    Dropdown
                    </a>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6Theme());

                    return NavBar::tag()
                        ->config($config, new ComponentContext('navbar'))
                        ->menu(
                            Menu::tag()
                                ->id('test-menu')
                                ->items(
                                    Dropdown::tag()
                                        ->containerTag(false)
                                        ->id(null)
                                        ->items(
                                            Item::tag()
                                                ->label('Action')
                                                ->link('#')
                                        )
                                )
                        )
                        ->render();
                },
            ],
        ];
    }
}
