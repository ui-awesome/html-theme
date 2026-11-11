<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\NavBar;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Provider\NavBarDefaultWithDropdownProvider;

/**
 * Unit tests for {@see Bootstrap5Theme} and {@see Bootstrap6Theme} navbar rendering with a nested dropdown.
 *
 * {@see NavBarDefaultWithDropdownProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class DefaultWithDropdownTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(NavBarDefaultWithDropdownProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            'Rendered navbar markup must match.',
        );
    }
}
