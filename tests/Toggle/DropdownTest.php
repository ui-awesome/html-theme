<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Toggle;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\ToggleDropdownProvider;

/**
 * Unit tests for {@see Bootstrap5} and {@see Bootstrap6} dropdown toggle rendering.
 *
 * {@see ToggleDropdownProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class DropdownTest
{
    /**
     * @param non-empty-string $expected
     * @param Closure(): string $render
     */
    #[DataProvider(ToggleDropdownProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::string($render())
            ->contains(
                $expected,
                'Rendered toggle markup must contain the expected fragment.',
            );
    }
}
