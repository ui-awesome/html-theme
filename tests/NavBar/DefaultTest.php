<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\NavBar;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\NavBarDefaultProvider;

/**
 * Unit tests for {@see Bootstrap5} and {@see Bootstrap6} default navbar rendering.
 *
 * {@see NavBarDefaultProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class DefaultTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(NavBarDefaultProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            'Rendered navbar markup must match.',
        );
    }
}
