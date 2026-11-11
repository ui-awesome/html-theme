<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Breadcrumb;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\BreadcrumbDividerProvider;

/**
 * Unit tests for {@see Bootstrap5} and {@see Bootstrap6} breadcrumb rendering with a custom divider.
 *
 * {@see BreadcrumbDividerProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class DividerTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(BreadcrumbDividerProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            'Rendered breadcrumb markup must match.',
        );
    }
}
