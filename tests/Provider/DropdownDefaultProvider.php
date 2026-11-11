<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\{Dropdown, Item};
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Dropdown\DefaultTest;

/**
 * Provides fixed expected markup and deferred builders for {@see DefaultTest}.
 */
final class DropdownDefaultProvider
{
    /**
     * @return array<string, array{string, Closure(): string}>
     */
    public static function render(): array
    {
        return [
            'Bootstrap 5' => [
                <<<HTML
                    <div class="dropdown" id="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" aria-expanded="false" data-bs-toggle="dropdown">
                    Dropdown button
                    </button>
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
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Dropdown::tag()
                        ->config($config, new ComponentContext('dropdown'))
                        ->id('dropdown')
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
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                <<<HTML
                    <div id="dropdown">
                    <button class="btn-solid theme-secondary menu-toggle" type="button" aria-expanded="false" data-bs-toggle="menu">
                    Dropdown button
                    </button>
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
                    </div>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Dropdown::tag()
                        ->config($config, new ComponentContext('dropdown'))
                        ->id('dropdown')
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
                        ->render();
                },
            ],
        ];
    }
}
