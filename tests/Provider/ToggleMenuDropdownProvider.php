<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\{Dropdown, Item, Menu, NavBar};
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Toggle\MenuDropdownTest;

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
                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false" data-bs-toggle="dropdown">
                    Dropdown
                    </a>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

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
                    <a class="nav-link menu-toggle" href="#" role="button" aria-expanded="false" data-bs-toggle="menu">
                    Dropdown
                    </a>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

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
