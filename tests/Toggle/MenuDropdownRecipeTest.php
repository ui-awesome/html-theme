<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Toggle;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\ToggleMenuDropdownRecipeProvider;

/**
 * Unit tests for {@see Bootstrap5} and {@see Bootstrap6} standalone menu dropdown toggle recipe rendering.
 *
 * {@see ToggleMenuDropdownRecipeProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class MenuDropdownRecipeTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(ToggleMenuDropdownRecipeProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            'Rendered toggle markup must match.',
        );
    }
}
