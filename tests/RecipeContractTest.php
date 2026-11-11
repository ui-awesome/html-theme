<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests;

use RuntimeException;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Core\Config\ComponentContext;
use UIAwesome\Html\Core\Theme\ThemeInterface;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\Provider\RecipeProvider;

use function iterator_to_array;

/**
 * Unit tests for {@see Bootstrap5Theme} and {@see Bootstrap6Theme} recipe dispatch and diagnostic recipe names.
 *
 * {@see RecipeProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class RecipeContractTest
{
    /**
     * @param class-string<ThemeInterface> $themeClass
     */
    #[DataProvider(RecipeProvider::class . '::supported')]
    public function resolvesExactlyOneNamedRecipe(string $themeClass, ComponentContext $context, string $expected): void
    {
        $recipes = iterator_to_array((new $themeClass())->getRecipes($context));

        Assert::count(
            $recipes,
            1,
            'Each supported context must resolve exactly one recipe.',
        );

        $recipe = $recipes[0] ?? throw new RuntimeException('A supported context returned no recipe.');

        Assert::same(
            $recipe->name,
            $expected,
            'Recipe name must identify the theme and exact semantic context.',
        );
        Assert::notBlank(
            $recipe->cookbook->calls,
            'A resolved recipe must contain configuration calls.',
        );
    }
}
