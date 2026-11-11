<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\{Breadcrumb, Item};
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Breadcrumb\DividerTest;

/**
 * Provides fixed expected markup and deferred builders for {@see DividerTest}.
 */
final class BreadcrumbDividerProvider
{
    /**
     * @return array<string, array{string, Closure(): string}>
     */
    public static function render(): array
    {
        return [
            'Bootstrap 5' => [
                <<<HTML
                    <nav id="breadcrumb_658fec01ac6cf" style='--bs-breadcrumb-divider: &apos;&gt;&apos;' aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="/">
                    Home
                    </a>
                    </li>
                    <li class="breadcrumb-item">
                    <a href="/library">
                    Library
                    </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                    Data
                    </li>
                    </ol>
                    </nav>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5());

                    return Breadcrumb::tag()
                        ->config($config, new ComponentContext('breadcrumb'))
                        ->currentPath('/data')
                        ->id('breadcrumb_658fec01ac6cf')
                        ->items(
                            Item::tag()
                                ->label('Home')
                                ->link('/'),
                            Item::tag()
                                ->label('Library')
                                ->link('/library'),
                            Item::tag()->label('Data')->link('/data'),
                        )
                        ->style("--bs-breadcrumb-divider: '>'")
                        ->render();
                },
            ],
            'Bootstrap 6' => [
                <<<HTML
                    <nav id="breadcrumb_658fec01ac6cf" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a class="breadcrumb-link" href="/">
                    Home
                    </a>
                    </li>
                    <li class="breadcrumb-item">
                    <span class="breadcrumb-divider" aria-hidden="true">&gt;</span>
                    <a class="breadcrumb-link" href="/library">
                    Library
                    </a>
                    </li>
                    <li class="breadcrumb-item">
                    <span class="breadcrumb-divider" aria-hidden="true">&gt;</span>
                    <span class="breadcrumb-link active" aria-current="page">
                    Data
                    </span>
                    </li>
                    </ol>
                    </nav>
                    HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6());

                    return Breadcrumb::tag()
                        ->config($config, new ComponentContext('breadcrumb'))
                        ->currentPath('/data')
                        ->id('breadcrumb_658fec01ac6cf')
                        ->items(
                            Item::tag()
                                ->label('Home')
                                ->link('/'),
                            Item::tag()
                                ->label('Library')
                                ->link('/library'),
                            Item::tag()
                                ->label('Data')
                                ->link('/data'),
                        )
                        ->separator('<span class="breadcrumb-divider" aria-hidden="true">&gt;</span>')
                        ->render();
                },
            ],
        ];
    }
}
