<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Dropdown;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\DropdownDefaultProvider;

/**
 * Unit tests for {@see Bootstrap5} and {@see Bootstrap6} default dropdown rendering.
 *
 * {@see DropdownDefaultProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class DefaultTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(DropdownDefaultProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            'Rendered dropdown markup must match.',
        );
    }
}
