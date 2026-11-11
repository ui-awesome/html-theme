<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\Toggle;
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Toggle\SelectorThemeTest;

/**
 * Provides fixed expected markup and deferred builders for {@see SelectorThemeTest}.
 */
final class ToggleSelectorThemeProvider
{
    /**
     * @return array<string, array{string, Closure(): string}>
     */
    public static function render(): array
    {
        return [
            'Bootstrap 5' => [
                <<<HTML
                    <button class="btn ms-2 me-2" type="button" title="Switch light/dark mode">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="32" height="32" fill="currentColor" viewBox="0 0 24 24" class="d-none" id="theme-dark-icon"><path fill-rule="evenodd" d="M11.675 2.015a.998.998 0 0 0-.403.011C6.09 2.4 2 6.722 2 12c0 5.523 4.477 10 10 10 4.356 0 8.058-2.784 9.43-6.667a1 1 0 0 0-1.02-1.33c-.08.006-.105.005-.127.005h-.001l-.028-.002A5.227 5.227 0 0 0 20 14a8 8 0 0 1-8-8c0-.952.121-1.752.404-2.558a.996.996 0 0 0 .096-.428V3a1 1 0 0 0-.825-.985Z" clip-rule="evenodd"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="32" height="32" fill="currentColor" viewBox="0 0 24 24" class="d-none" id="theme-light-icon"><path fill-rule="evenodd" d="M13 3a1 1 0 1 0-2 0v2a1 1 0 1 0 2 0V3ZM6.343 4.929A1 1 0 0 0 4.93 6.343l1.414 1.414a1 1 0 0 0 1.414-1.414L6.343 4.929Zm12.728 1.414a1 1 0 0 0-1.414-1.414l-1.414 1.414a1 1 0 0 0 1.414 1.414l1.414-1.414ZM12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm-9 4a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H3Zm16 0a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2ZM7.757 17.657a1 1 0 1 0-1.414-1.414l-1.414 1.414a1 1 0 1 0 1.414 1.414l1.414-1.414Zm9.9-1.414a1 1 0 0 0-1.414 1.414l1.414 1.414a1 1 0 0 0 1.414-1.414l-1.414-1.414ZM13 19a1 1 0 1 0-2 0v2a1 1 0 1 0 2 0v-2Z" clip-rule="evenodd"/></svg>
                    </button>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5Theme());

                    return Toggle::tag()
                        ->config($config, new ComponentContext('toggle', variant: 'selector-theme'))
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                <<<HTML
                    <button class="btn ms-3 me-3" type="button" title="Switch light/dark mode" aria-label="Switch light/dark mode">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="32" height="32" fill="currentColor" viewBox="0 0 24 24" class="d-none" id="theme-dark-icon"><path fill-rule="evenodd" d="M11.675 2.015a.998.998 0 0 0-.403.011C6.09 2.4 2 6.722 2 12c0 5.523 4.477 10 10 10 4.356 0 8.058-2.784 9.43-6.667a1 1 0 0 0-1.02-1.33c-.08.006-.105.005-.127.005h-.001l-.028-.002A5.227 5.227 0 0 0 20 14a8 8 0 0 1-8-8c0-.952.121-1.752.404-2.558a.996.996 0 0 0 .096-.428V3a1 1 0 0 0-.825-.985Z" clip-rule="evenodd"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="32" height="32" fill="currentColor" viewBox="0 0 24 24" class="d-none" id="theme-light-icon"><path fill-rule="evenodd" d="M13 3a1 1 0 1 0-2 0v2a1 1 0 1 0 2 0V3ZM6.343 4.929A1 1 0 0 0 4.93 6.343l1.414 1.414a1 1 0 0 0 1.414-1.414L6.343 4.929Zm12.728 1.414a1 1 0 0 0-1.414-1.414l-1.414 1.414a1 1 0 0 0 1.414 1.414l1.414-1.414ZM12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm-9 4a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H3Zm16 0a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2ZM7.757 17.657a1 1 0 1 0-1.414-1.414l-1.414 1.414a1 1 0 1 0 1.414 1.414l1.414-1.414Zm9.9-1.414a1 1 0 0 0-1.414 1.414l1.414 1.414a1 1 0 0 0 1.414-1.414l-1.414-1.414ZM13 19a1 1 0 1 0-2 0v2a1 1 0 1 0 2 0v-2Z" clip-rule="evenodd"/></svg>
                    </button>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6Theme());

                    return Toggle::tag()
                        ->config($config, new ComponentContext('toggle', variant: 'selector-theme'))
                        ->render();
                },
            ],
        ];
    }
}
