<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Breadcrumb;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Provider\BreadcrumbDefaultProvider;

/**
 * Unit tests for {@see Bootstrap5Theme} and {@see Bootstrap6Theme} default breadcrumb rendering.
 *
 * {@see BreadcrumbDefaultProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class DefaultTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(BreadcrumbDefaultProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            'Rendered breadcrumb markup must match.',
        );
    }
}
