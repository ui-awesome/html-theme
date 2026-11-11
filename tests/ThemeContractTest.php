<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests;

use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Core\Component\{Alert, Breadcrumb, Dropdown, Item, Menu, NavBar, Toggle};
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Core\Theme\ThemeInterface;
use UIAwesome\Html\Field\Factory\ControlFactory;
use UIAwesome\Html\Field\Field;
use UIAwesome\Html\Form\{CheckboxList, ChoiceItem, RadioList};
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\Provider\ThemeProvider;
use UIAwesome\Html\Theme\Tests\Support\DemoForm;

use function iterator_to_array;
use function substr_count;

/**
 * Unit tests for {@see Bootstrap5} and {@see Bootstrap6} through real component and field rendering.
 *
 * {@see ThemeProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class ThemeContractTest
{
    /**
     * @param array<non-empty-string, string> $contains Expected markup fragments mapped to their failure messages.
     * @param array<non-empty-string, array{int, string}> $counts Markup fragments mapped to their expected count and
     * failure message.
     */
    #[DataProvider(ThemeProvider::class . '::breadcrumbs')]
    public function breadcrumbStylesCurrentItemAndSeparators(
        ThemeInterface $theme,
        array $contains,
        array $counts,
    ): void {
        $html = Breadcrumb::tag()
            ->config(new Config($theme), new ComponentContext('breadcrumb'))
            ->id('trail')
            ->currentPath('/current')
            ->items(Item::tag()->label('Home')->link('/'), Item::tag()->label('Current')->link('/current'))
            ->render();

        Assert::string($html)->contains(
            'class="breadcrumb"',
            'List class must be applied.',
        );
        Assert::string($html)->contains(
            'aria-current="page"',
            'Current item must be marked.',
        );
        Assert::string($html)->contains(
            'aria-label="breadcrumb"',
            'Navigation landmark must be labelled.',
        );

        foreach ($contains as $needle => $message) {
            Assert::string($html)->contains(
                $needle,
                $message,
            );
        }

        foreach ($counts as $needle => [$count, $message]) {
            Assert::same(
                substr_count($html, $needle),
                $count,
                $message,
            );
        }
    }

    #[DataProvider(ThemeProvider::class . '::choiceLists')]
    public function choiceListsStyleEachBoundOption(
        ThemeInterface $theme,
        string $type,
        CheckboxList|RadioList $input,
        string $expectedClass,
    ): void {
        $input = $input->items(
            (new ChoiceItem())
                ->value('not-an-email')
                ->label('Selected'),
            (new ChoiceItem())
                ->value('other')
                ->label('Other'),
        );

        $config = new Config(
            $theme,
            factory: new ControlFactory(
                [
                    $type => static fn(): CheckboxList|RadioList => $input,
                ],
            ),
        );

        $html = Field::tag()
            ->config($config)
            ->formModel(new DemoForm())
            ->property('email')
            ->control($type)
            ->render();

        Assert::same(
            substr_count($html, 'class="' . $expectedClass . '"'),
            2,
            'Every option must receive the input class.',
        );
        Assert::string($html)->contains(
            'value="not-an-email" checked',
            'Bound option must remain selected.',
        );
        Assert::string($html)->contains(
            'for="demoform-email-0"',
            'First label must target its option.',
        );
        Assert::string($html)->contains(
            'for="demoform-email-1"',
            'Second label must target its option.',
        );
    }

    /**
     * @param array<non-empty-string, string> $contains Expected markup fragments mapped to their failure messages.
     * @param array<non-empty-string, string> $notContains Forbidden markup fragments mapped to their failure messages.
     */
    #[DataProvider(ThemeProvider::class . '::dropdowns')]
    public function dropdownVariantsStyleActiveAndDisabledItems(
        ThemeInterface $theme,
        string|null $variant,
        array $contains,
        array $notContains,
    ): void {
        $html = Dropdown::tag()
            ->config(new Config($theme), new ComponentContext('dropdown', variant: $variant))
            ->id('choices')
            ->items(
                Item::tag()
                    ->label('Selected')
                    ->link('/selected')
                    ->active(),
                Item::tag()
                    ->label('Unavailable')
                    ->link('/disabled')
                    ->disabled(),
            )
            ->render();

        Assert::string($html)->contains(
            'aria-expanded="false"',
            'Toggle must start collapsed.',
        );
        Assert::string($html)->contains(
            'Selected',
            'Active item must be rendered.',
        );
        Assert::string($html)->contains(
            'Unavailable',
            'Disabled item must be rendered.',
        );

        foreach ($contains as $needle => $message) {
            Assert::string($html)->contains(
                $needle,
                $message,
            );
        }

        foreach ($notContains as $needle => $message) {
            Assert::string($html)->notContains(
                $needle,
                $message,
            );
        }
    }

    /**
     * @param array<non-empty-string, string> $contains Expected markup fragments mapped to their failure messages.
     * @param array<non-empty-string, string> $notContains Forbidden markup fragments mapped to their failure messages.
     */
    #[DataProvider(ThemeProvider::class . '::navbars')]
    public function navbarVariantsRenderNestedMenu(
        ThemeInterface $theme,
        string|null $variant,
        array $contains,
        array $notContains,
    ): void {
        $html = NavBar::tag()
            ->config(new Config($theme), new ComponentContext('navbar', variant: $variant))
            ->id('navigation')
            ->brandLink('/')
            ->brandText('Brand')
            ->menu(
                Menu::tag()
                    ->id('menu')
                    ->items(
                        Item::tag()
                            ->label('Home')
                            ->link('/')
                            ->active(),
                        Item::tag()
                            ->label('Disabled')
                            ->link('/disabled')
                            ->disabled(),
                        Dropdown::tag()
                            ->id(null)
                            ->containerTag(false)
                            ->items(
                                Item::tag()
                                    ->label('Nested')
                                    ->link('/nested'),
                            ),
                    ),
            )
            ->render();

        Assert::string($html)->contains(
            'navbar-brand',
            'Brand class must be applied.',
        );
        Assert::string($html)->contains(
            'nav-link active',
            'Active link class must be applied.',
        );
        Assert::string($html)->contains(
            'nav-link disabled',
            'Disabled link class must be applied.',
        );
        Assert::string($html)->contains(
            'Nested',
            'Nested dropdown item must be rendered.',
        );

        foreach ($contains as $needle => $message) {
            Assert::string($html)->contains(
                $needle,
                $message,
            );
        }

        foreach ($notContains as $needle => $message) {
            Assert::string($html)->notContains(
                $needle,
                $message,
            );
        }
    }

    public function neutralAlertAndResponsiveMenuDifferByVersion(): void
    {
        $bootstrap5 = new Bootstrap5();
        $bootstrap6 = new Bootstrap6();

        Assert::same(
            $bootstrap5->getName(),
            'bootstrap5',
            'Bootstrap 5 name must remain stable.',
        );
        Assert::same(
            $bootstrap6->getName(),
            'bootstrap6',
            'Bootstrap 6 name must remain stable.',
        );
        Assert::same(
            iterator_to_array($bootstrap5->getRecipes(new ComponentContext('alert'))),
            [],
            'Bootstrap 5 must not style a neutral alert.',
        );
        Assert::count(
            iterator_to_array($bootstrap6->getRecipes(new ComponentContext('alert'))),
            1,
            'Bootstrap 6 must style a neutral alert.',
        );
        Assert::count(
            iterator_to_array($bootstrap5->getRecipes(new ComponentContext('toggle', variant: 'menu'))),
            1,
            'Bootstrap 5 must style the responsive menu toggle.',
        );
        Assert::same(
            iterator_to_array($bootstrap6->getRecipes(new ComponentContext('toggle', variant: 'menu'))),
            [],
            'Bootstrap 6 must not style the responsive menu toggle.',
        );
        Assert::same(
            iterator_to_array($bootstrap6->getRecipes(new ComponentContext('alert', variant: 'light'))),
            [],
            'Bootstrap 6 must not accept the `light` variant.',
        );
        Assert::same(
            iterator_to_array($bootstrap6->getRecipes(new ComponentContext('alert', variant: 'dark'))),
            [],
            'Bootstrap 6 must not accept the `dark` variant.',
        );
    }

    /**
     * @param array<non-empty-string, string> $contains Expected markup fragments mapped to their failure messages.
     */
    #[DataProvider(ThemeProvider::class . '::controls')]
    public function rendersAllFieldControls(ThemeInterface $theme, string $type, array $contains): void
    {
        $model = new DemoForm();

        $model->addError('email', 'Required <value>.');

        $html = Field::tag()
            ->config(new Config($theme))
            ->formModel($model)
            ->property('email')
            ->control($type)
            ->render();

        Assert::string($html)->contains(
            'Required &lt;value&gt;.',
            'Error must be encoded.',
        );
        Assert::string($html)->contains(
            'invalid-feedback d-block',
            'Feedback classes must be applied.',
        );
        Assert::string($html)->contains(
            'is-invalid',
            'Invalid state class must be applied.',
        );
        Assert::string($html)->contains(
            'form-text',
            'Hint class must be applied.',
        );
        Assert::string($html)->contains(
            'demoform-email-help',
            'Hint identifier must be rendered.',
        );
        Assert::string($html)->notContains(
            'Required <value>.',
            'Raw error markup must not be rendered.',
        );

        foreach ($contains as $needle => $message) {
            Assert::string($html)->contains(
                $needle,
                $message,
            );
        }
    }

    /**
     * @param list<string> $states Semantic states applied to the alert context.
     * @param int $dismissButtons Expected number of dismiss buttons.
     * @param array<non-empty-string, string> $contains Expected markup fragments mapped to their failure messages.
     * @param array<non-empty-string, string> $notContains Forbidden markup fragments mapped to their failure messages.
     */
    #[DataProvider(ThemeProvider::class . '::alerts')]
    public function rendersEveryAlertVariant(
        ThemeInterface $theme,
        string $variant,
        array $states,
        int $dismissButtons,
        array $contains,
        array $notContains,
    ): void {
        $html = Alert::tag()
            ->config(
                new Config($theme),
                new ComponentContext('alert', variant: $variant, states: $states),
            )
            ->content('<img src=x>')
            ->id('notice')
            ->render();

        Assert::string($html)->contains(
            'role="alert"',
            'Alert role must be rendered.',
        );
        Assert::string($html)->contains(
            '&lt;img src=x&gt;',
            'Content must be encoded.',
        );
        Assert::same(
            substr_count($html, 'data-bs-dismiss="alert"'),
            $dismissButtons,
            'Dismiss button must render only for the `dismissible` state.',
        );

        foreach ($contains as $needle => $message) {
            Assert::string($html)->contains(
                $needle,
                $message,
            );
        }

        foreach ($notContains as $needle => $message) {
            Assert::string($html)->notContains(
                $needle,
                $message,
            );
        }
    }

    #[DataProvider(ThemeProvider::class . '::themes')]
    public function themeApplicationPreservesBaseComponent(ThemeInterface $theme): void
    {
        $base = Alert::tag()
            ->id('base')
            ->content('Message');

        $themed = $base->config(
            new Config($theme),
            new ComponentContext('alert', variant: 'danger'),
        );

        Assert::string($base->render())->notContains(
            'class=',
            'Base component must stay unstyled.',
        );
        Assert::string($themed->render())->contains(
            'danger',
            'Themed copy must receive the variant.',
        );
    }

    #[DataProvider(ThemeProvider::class . '::themes')]
    public function themeSwitcherContainsBothIcons(ThemeInterface $theme): void
    {
        $html = Toggle::tag()
            ->config(
                new Config($theme),
                new ComponentContext('toggle', variant: 'selector-theme'),
            )
            ->render();

        Assert::same(
            substr_count($html, '<svg'),
            2,
            'Both icons must be rendered.',
        );
        Assert::string($html)->contains(
            'id="theme-dark-icon"',
            'Dark icon must be rendered.',
        );
        Assert::string($html)->contains(
            'id="theme-light-icon"',
            'Light icon must be rendered.',
        );
        Assert::string($html)->contains(
            'Switch light/dark mode',
            'Toggle must be labelled.',
        );
    }

    #[DataProvider(ThemeProvider::class . '::themes')]
    public function unknownContextsAndVariantsDoNotApplyRecipes(ThemeInterface $theme): void
    {
        foreach (['unknown', 'field.container', 'field.prefix', 'field.suffix'] as $component) {
            Assert::same(
                iterator_to_array($theme->getRecipes(new ComponentContext($component))),
                [],
                "Context `{$component}` must not resolve a recipe.",
            );
        }

        foreach (['alert', 'dropdown', 'navbar', 'toggle'] as $component) {
            Assert::same(
                iterator_to_array($theme->getRecipes(new ComponentContext($component, variant: 'unknown'))),
                [],
                "Unknown `{$component}` variant must not resolve a recipe.",
            );
        }

        foreach (['alert', 'dropdown', 'selector-language'] as $variant) {
            Assert::same(
                iterator_to_array($theme->getRecipes(new ComponentContext('toggle', variant: $variant))),
                [],
                "Toggle variant `{$variant}` must not resolve a recipe.",
            );
        }
    }
}
