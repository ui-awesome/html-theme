<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Toggle;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Provider\ToggleSelectorThemeProvider;

/**
 * Unit tests for {@see Bootstrap5Theme} and {@see Bootstrap6Theme} color mode selector toggle rendering.
 *
 * {@see ToggleSelectorThemeProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class SelectorThemeTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(ToggleSelectorThemeProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            'Rendered toggle markup must match.',
        );
    }
}
