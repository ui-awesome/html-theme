<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Dropdown;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Provider\DropdownSelectorLanguageProvider;

/**
 * Unit tests for {@see Bootstrap5Theme} and {@see Bootstrap6Theme} language selector dropdown rendering.
 *
 * {@see DropdownSelectorLanguageProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class SelectorLanguageTest
{
    /**
     * @param Closure(): string $render
     */
    #[DataProvider(DropdownSelectorLanguageProvider::class . '::render')]
    public function render(string $expected, Closure $render): void
    {
        Assert::same(
            $render(),
            $expected,
            'Rendered dropdown markup must match.',
        );
    }
}
