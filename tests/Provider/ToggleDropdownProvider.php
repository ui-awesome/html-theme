<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\{Dropdown, Item};
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Toggle\DropdownTest;

/**
 * Provides fixed expected markup and deferred builders for {@see DropdownTest}.
 */
final class ToggleDropdownProvider
{
    /**
     * @return array<string, array{string, Closure(): string}>
     */
    public static function render(): array
    {
        return [
            'Bootstrap 5' => [
                <<<HTML
                    <button class="btn btn-secondary dropdown-toggle" type="button" aria-expanded="false" data-bs-toggle="dropdown">
                    Dropdown button
                    </button>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5Theme());

                    return Dropdown::tag()
                        ->config($config, new ComponentContext('dropdown'))
                        ->id('test-dropdown')
                        ->items(
                            Item::tag()
                                ->label('Action')
                                ->link('#'),
                        )
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                <<<'HTML'
                    <button class="btn-solid theme-secondary menu-toggle" type="button" aria-expanded="false" data-bs-toggle="menu">
                    Dropdown button
                    </button>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6Theme());

                    return Dropdown::tag()
                        ->config($config, new ComponentContext('dropdown'))
                        ->id('test-dropdown')
                        ->items(
                            Item::tag()
                                ->label('Action')
                                ->link('#'),
                        )
                        ->render();
                },
            ],
        ];
    }
}
