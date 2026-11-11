<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Alert;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Provider\AlertDismissProvider;

/**
 * Unit tests for {@see Bootstrap5Theme} and {@see Bootstrap6Theme} dismissible alert rendering per contextual variant.
 *
 * {@see AlertDismissProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class DismissTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(AlertDismissProvider::class . '::danger')]
    #[DataProvider(AlertDismissProvider::class . '::dark')]
    #[DataProvider(AlertDismissProvider::class . '::info')]
    #[DataProvider(AlertDismissProvider::class . '::light')]
    #[DataProvider(AlertDismissProvider::class . '::primary')]
    #[DataProvider(AlertDismissProvider::class . '::secondary')]
    #[DataProvider(AlertDismissProvider::class . '::success')]
    #[DataProvider(AlertDismissProvider::class . '::warning')]
    public function render(string $variant, string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            "Rendered {$variant} dismissible alert markup must match.",
        );
    }
}
