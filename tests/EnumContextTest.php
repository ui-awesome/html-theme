<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests;

use Closure;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Core\Config\{ComponentContext, Config, Recipe};
use UIAwesome\Html\Core\Theme\ThemeInterface;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\EnumContextProvider;

use function array_map;
use function iterator_to_array;

/**
 * Unit tests for {@see Bootstrap5} and {@see Bootstrap6} parity between enum-built and string-built contexts.
 *
 * {@see EnumContextProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class EnumContextTest
{
    /**
     * @param list<string> $expected Recipe names both contexts must resolve, in application order.
     * @param Closure(Config, ComponentContext): string $render
     */
    #[DataProvider(EnumContextProvider::class . '::contexts')]
    public function enumContextResolvesLikeStringContext(
        ThemeInterface $theme,
        ComponentContext $enumContext,
        ComponentContext $stringContext,
        array $expected,
        Closure $render,
    ): void {
        Assert::same(
            array_map(
                static fn(Recipe $recipe): string => $recipe->name,
                iterator_to_array($theme->getRecipes($enumContext), false),
            ),
            $expected,
            'Enum context must resolve the expected recipes.',
        );
        Assert::same(
            array_map(
                static fn(Recipe $recipe): string => $recipe->name,
                iterator_to_array($theme->getRecipes($stringContext), false),
            ),
            $expected,
            'String context must resolve the expected recipes.',
        );
        Assert::same(
            $render(new Config($theme), $enumContext),
            $render(new Config($theme), $stringContext),
            'Rendered markup must not depend on how the context was built.',
        );
    }
}
