<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\{Dropdown, Item, Menu, NavBar, Toggle};
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\NavBar\DropdownExplicitToggleTest;

/**
 * Provides fixed expected markup and deferred builders for {@see DropdownExplicitToggleTest}.
 */
final class NavBarDropdownExplicitToggleProvider
{
    /**
     * @return array<string, array{string, Closure(): string}>
     */
    public static function render(): array
    {
        return [
            'Bootstrap 5' => [
                <<<HTML
                    <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="menu">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link" href="/">
                    Home
                    </a>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false" data-bs-toggle="dropdown">
                    Docs
                    </a>
                    <ul class="dropdown-menu">
                    <li>
                    <a class="dropdown-item" href="/guide">
                    Guide
                    </a>
                    </li>
                    </ul>
                    </li>
                    </ul>
                    </div>
                    </div>
                    </nav>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return NavBar::tag()
                        ->config($config, new ComponentContext('navbar'))
                        ->menu(
                            Menu::tag()
                                ->id('menu')
                                ->items(
                                    Item::tag()
                                        ->label('Home')
                                        ->link('/'),
                                    Dropdown::tag()
                                        ->containerTag(false)
                                        ->id(null)
                                        ->items(
                                            Item::tag()
                                                ->label('Guide')
                                                ->link('/guide'),
                                        )
                                        ->toggle(
                                            Toggle::tag()
                                                ->config($config, new ComponentContext('toggle', variant: 'menu-dropdown'))
                                                ->content('Docs'),
                                        ),
                                ),
                        )
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                <<<HTML
                    <nav class="navbar navbar-expand bg-1">
                    <div class="container-fluid">
                    <div class="flex-grow-1" id="menu">
                    <ul class="nav navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link" href="/">
                    Home
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link menu-toggle" href="#" role="button" aria-expanded="false" data-bs-toggle="menu">
                    Docs
                    </a>
                    <ul class="menu">
                    <li>
                    <a class="menu-item" href="/guide">
                    Guide
                    </a>
                    </li>
                    </ul>
                    </li>
                    </ul>
                    </div>
                    </div>
                    </nav>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return NavBar::tag()
                        ->config($config, new ComponentContext('navbar'))
                        ->menu(
                            Menu::tag()
                                ->id('menu')
                                ->items(
                                    Item::tag()
                                        ->label('Home')
                                        ->link('/'),
                                    Dropdown::tag()
                                        ->containerTag(false)
                                        ->id(null)
                                        ->items(
                                            Item::tag()
                                                ->label('Guide')
                                                ->link('/guide'),
                                        )
                                        ->toggle(
                                            Toggle::tag()
                                                ->config($config, new ComponentContext('toggle', variant: 'menu-dropdown'))
                                                ->content('Docs'),
                                        ),
                                ),
                        )
                        ->render();
                },
            ],
        ];
    }
}
