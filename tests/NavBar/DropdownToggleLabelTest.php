<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\NavBar;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\NavBarDropdownToggleLabelProvider;

/**
 * Unit tests for {@see Bootstrap5} and {@see Bootstrap6} navbar rendering with a nested dropdown that relabels
 * the themed toggle through `toggleLabel()`.
 *
 * {@see NavBarDropdownToggleLabelProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class DropdownToggleLabelTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(NavBarDropdownToggleLabelProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        $html = $render();

        Assert::same(
            $html,
            $expected,
            'Rendered navbar markup must match.',
        );
        Assert::string($html)->notContains(
            'Dropdown',
            'Default toggle label must not be rendered.',
        );
    }
}
