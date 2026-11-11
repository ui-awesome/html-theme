<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\FieldRenderingProvider;

/**
 * Unit tests for {@see Bootstrap5} and {@see Bootstrap6} form field markup.
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
