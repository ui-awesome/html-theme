<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Toggle;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Provider\ToggleMenuProvider;
use UIAwesome\Html\Theme\Bootstrap\Tests\ThemeContractTest;

/**
 * Unit tests for {@see Bootstrap5Theme} responsive menu toggle rendering.
 *
 * {@see Bootstrap6Theme} resolves no `toggle` recipe for the `menu` variant, which
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
