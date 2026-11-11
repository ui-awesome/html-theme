<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Provider\FieldRenderingProvider;

/**
 * Unit tests for {@see Bootstrap5Theme} and {@see Bootstrap6Theme} form field markup.
 *
 * {@see FieldRenderingProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class FieldRenderingTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(FieldRenderingProvider::class . '::cases')]
    public function render(string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            'The field must render the expected Bootstrap markup.',
        );
    }
}
