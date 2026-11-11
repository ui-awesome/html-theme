<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\{Dropdown, Item, Menu, NavBar, Toggle};
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\NavBar\DefaultWithDropdownTest;

/**
 * Provides fixed expected markup and deferred builders for {@see DefaultWithDropdownTest}.
 */
final class NavBarDefaultWithDropdownProvider
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
                    <a class="navbar-brand" href="#">
                    Navbar
                    </a>
                    <button class="navbar-toggler" type="button" aria-expanded="false" aria-label="Toggle navigation" data-bs-toggle="collapse" aria-controls="menu_1" data-bs-target="#menu_1">
                    <span class="navbar-toggler-icon">
                    </span>
                    </button>
                    <div class="collapse navbar-collapse" id="menu_1">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" href="/home" aria-current="page">
                    Home
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/link">
                    Link
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link disabled" href="/disable">
                    Disable
                    </a>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false" data-bs-toggle="dropdown">
                    Dropdown
                    </a>
                    <ul class="dropdown-menu">
                    <li>
                    <a class="dropdown-item" href="#">
                    Action
                    </a>
                    </li>
                    <li>
                    <a class="dropdown-item" href="#">
                    Another actionc
                    </a>
                    </li>
                    <li>
                    <a class="dropdown-item" href="#">
                    Something else here
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
                        ->brandLink('#')
                        ->brandText('Navbar')
                        ->config($config, new ComponentContext('navbar'))
                        ->brandToggle(
                            Toggle::tag()
                                ->config($config, new ComponentContext('toggle', variant: 'menu'))
                                ->ariaAttributes(['controls' => 'menu_1'])
                                ->dataAttributes(['bs-target' => '#menu_1']),
                        )
                        ->menu(
                            Menu::tag()
                                ->currentPath('/home')
                                ->id('menu_1')
                                ->items(
                                    Item::tag()
                                        ->label('Home')
                                        ->link('/home'),
                                    Item::tag()
                                        ->label('Link')
                                        ->link('/link'),
                                    Item::tag()
                                        ->label('Disable')
                                        ->link('/disable')
                                        ->disabled(),
                                    Dropdown::tag()
                                        ->containerTag(false)
                                        ->id(null)
                                        ->items(
                                            Item::tag()
                                                ->label('Action')
                                                ->link('#'),
                                            Item::tag()
                                                ->label('Another actionc')
                                                ->link('#'),
                                            Item::tag()
                                                ->label('Something else here')
                                                ->link('#'),
                                        )
                                )
                        )
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                <<<HTML
                    <nav class="navbar navbar-expand bg-1">
                    <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                    Navbar
                    </a>
                    <div class="flex-grow-1" id="menu_1">
                    <ul class="nav navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active" href="/home" aria-current="page">
                    Home
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/link">
                    Link
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link disabled" href="/disable">
                    Disable
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link menu-toggle" href="#" role="button" aria-expanded="false" data-bs-toggle="menu">
                    Dropdown
                    </a>
                    <ul class="menu">
                    <li>
                    <a class="menu-item" href="#">
                    Action
                    </a>
                    </li>
                    <li>
                    <a class="menu-item" href="#">
                    Another actionc
                    </a>
                    </li>
                    <li>
                    <a class="menu-item" href="#">
                    Something else here
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
                        ->brandLink('#')
                        ->brandText('Navbar')
                        ->config($config, new ComponentContext('navbar'))
                        ->menu(
                            Menu::tag()
                                ->currentPath('/home')
                                ->id('menu_1')
                                ->items(
                                    Item::tag()
                                        ->label('Home')
                                        ->link('/home'),
                                    Item::tag()
                                        ->label('Link')
                                        ->link('/link'),
                                    Item::tag()
                                        ->label('Disable')
                                        ->link('/disable')
                                        ->disabled(),
                                    Dropdown::tag()
                                        ->containerTag(false)
                                        ->id(null)
                                        ->items(
                                            Item::tag()
                                                ->label('Action')
                                                ->link('#'),
                                            Item::tag()
                                                ->label('Another actionc')
                                                ->link('#'),
                                            Item::tag()
                                                ->label('Something else here')
                                                ->link('#'),
                                        )
                                )
                        )
                        ->render();
                },
            ],
        ];
    }
}
