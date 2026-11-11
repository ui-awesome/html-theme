<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\Toggle;
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\Bootstrap5;
use UIAwesome\Html\Theme\Tests\Toggle\MenuTest;

/**
 * Provides fixed expected markup and deferred builders for {@see MenuTest}.
 */
final class ToggleMenuProvider
{
    /**
     * @return array<string, array{string, Closure(): string}>
     */
    public static function render(): array
    {
        return [
            'Bootstrap 5' => [
                <<<HTML
                    <button class="navbar-toggler" type="button" aria-expanded="false" aria-label="Toggle navigation" data-bs-toggle="collapse" data-bs-target="#">
                    <span class="navbar-toggler-icon">
                    </span>
                    </button>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Toggle::tag()
                        ->config($config, new ComponentContext('toggle', variant: 'menu'))
                        ->dataAttributes(['bs-target' => '#'])
                        ->render();
                },
            ],
        ];
    }
}
