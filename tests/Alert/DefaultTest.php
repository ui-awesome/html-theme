<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Alert;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Provider\AlertDefaultProvider;

/**
 * Unit tests for {@see Bootstrap5Theme} and {@see Bootstrap6Theme} alert rendering per contextual variant.
 *
 * {@see AlertDefaultProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class DefaultTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(AlertDefaultProvider::class . '::danger')]
    #[DataProvider(AlertDefaultProvider::class . '::dark')]
    #[DataProvider(AlertDefaultProvider::class . '::info')]
    #[DataProvider(AlertDefaultProvider::class . '::light')]
    #[DataProvider(AlertDefaultProvider::class . '::primary')]
    #[DataProvider(AlertDefaultProvider::class . '::secondary')]
    #[DataProvider(AlertDefaultProvider::class . '::success')]
    #[DataProvider(AlertDefaultProvider::class . '::warning')]
    public function render(string $variant, string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            "Rendered {$variant} alert markup must match.",
        );
    }
}
