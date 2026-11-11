<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Toggle;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\ToggleMenuProvider;
use UIAwesome\Html\Theme\Tests\ThemeContractTest;

/**
 * Unit tests for {@see Bootstrap5} responsive menu toggle rendering.
 *
 * {@see Bootstrap6} resolves no `toggle` recipe for the `menu` variant, which
 * {@see ThemeContractTest::neutralAlertAndResponsiveMenuDifferByVersion()} asserts.
 *
 * {@see ToggleMenuProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class MenuTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(ToggleMenuProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            'Rendered toggle markup must match.',
        );
    }
}
