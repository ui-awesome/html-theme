<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Alert;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\AlertDismissProvider;

/**
 * Unit tests for {@see Bootstrap5} and {@see Bootstrap6} dismissible alert rendering per contextual variant.
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
