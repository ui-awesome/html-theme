<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Toggle;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Provider\ToggleMenuDropdownProvider;

/**
 * Unit tests for {@see Bootstrap5Theme} and {@see Bootstrap6Theme} menu dropdown toggle rendering.
 *
 * {@see ToggleMenuDropdownProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class MenuDropdownTest
{
    /**
     * @param non-empty-string $expected
     * @param Closure(): string $render
     */
    #[DataProvider(ToggleMenuDropdownProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::string($render())->contains(
            $expected,
            'Rendered toggle markup must contain the expected fragment.',
        );
    }
}
