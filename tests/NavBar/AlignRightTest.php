<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\NavBar;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\NavBarAlignRightProvider;

/**
 * Unit tests for {@see Bootstrap5} and {@see Bootstrap6} right-aligned navbar rendering.
 *
 * {@see NavBarAlignRightProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class AlignRightTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(NavBarAlignRightProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            'Rendered navbar markup must match.',
        );
    }
}
