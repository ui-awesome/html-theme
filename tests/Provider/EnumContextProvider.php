<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Component\{Alert, Dropdown, Item, Menu, NavBar, Toggle};
use UIAwesome\Html\Core\Component\Values\{ComponentName, ComponentState, DropdownVariant, NavBarVariant, ToggleVariant};
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Core\Theme\ThemeInterface;
use UIAwesome\Html\Field\Values\FieldComponentName;
use UIAwesome\Html\Form\InputEmail;
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\EnumContextTest;

/**
 * Provides enum-built contexts, their string equivalents, expected recipe names, and deferred builders for
 * {@see EnumContextTest}.
 *
 * Bootstrap 6 resolves no recipe for the `menu` toggle variant, so that case expects no recipe for either context.
 */
final class EnumContextProvider
{
    /**
     * Theme labels mapped to the theme class, its recipe-name prefix, and the recipes it resolves for the `menu`
     * toggle variant.
     */
    private const array THEMES = [
        'Bootstrap 5' => [Bootstrap5::class, 'bootstrap5', ['bootstrap5.toggle.menu']],
        'Bootstrap 6' => [Bootstrap6::class, 'bootstrap6', []],
    ];

    /**
     * @return iterable<
     *     string,
     *     array{
     *         ThemeInterface,
     *         ComponentContext,
     *         ComponentContext,
     *         list<string>,
     *         Closure(Config, ComponentContext): string,
     *     },
     * >
     */
    public static function contexts(): iterable
    {
        foreach (self::THEMES as $label => [$themeClass, $name, $menuToggleRecipes]) {
            $theme = new $themeClass();

            yield "{$label}: Alert (state: ComponentState::DISMISSIBLE)" => [
                $theme,
                new ComponentContext(ComponentName::ALERT, variant: 'danger', states: [ComponentState::DISMISSIBLE]),
                new ComponentContext('alert', variant: 'danger', states: ['dismissible']),
                ["{$name}.alert.danger.dismissible"],
                static fn(Config $config, ComponentContext $context): string => Alert::tag()
                    ->config($config, $context)
                    ->content('Your session expired.')
                    ->id('alert-session')
                    ->render(),
            ];
            yield "{$label}: Dropdown (variant: DropdownVariant::LANGUAGE)" => [
                $theme,
                new ComponentContext(ComponentName::DROPDOWN, variant: DropdownVariant::LANGUAGE),
                new ComponentContext('dropdown', variant: 'language'),
                ["{$name}.dropdown.language"],
                static fn(Config $config, ComponentContext $context): string => Dropdown::tag()
                    ->config($config, $context)
                    ->id('selector-language')
                    ->items(
                        Item::tag()
                            ->label('English')
                            ->link('/language/en')
                            ->active(),
                    )
                    ->render(),
            ];
            yield "{$label}: Field (control: FieldComponentName::FIELD_CONTROL_EMAIL)" => [
                $theme,
                new ComponentContext(FieldComponentName::FIELD_CONTROL_EMAIL),
                new ComponentContext('field.control.email'),
                ["{$name}.field.control.email"],
                static fn(Config $config, ComponentContext $context): string => InputEmail::tag()
                    ->config($config, $context)
                    ->id('email')
                    ->render(),
            ];
            yield "{$label}: NavBar (variant: NavBarVariant::ALIGN_RIGHT)" => [
                $theme,
                new ComponentContext(ComponentName::NAVBAR, variant: NavBarVariant::ALIGN_RIGHT),
                new ComponentContext('navbar', variant: 'align-right'),
                ["{$name}.navbar.align-right"],
                static fn(Config $config, ComponentContext $context): string => NavBar::tag()
                    ->config($config, $context)
                    ->brandLink('/')
                    ->brandText('UI Awesome')
                    ->menu(
                        Menu::tag()
                            ->id('main-menu')
                            ->items(
                                Item::tag()
                                    ->label('Home')
                                    ->link('/'),
                                Dropdown::tag()
                                    ->containerTag(false)
                                    ->id(null)
                                    ->items(
                                        Item::tag()
                                            ->label('Action')
                                            ->link('#'),
                                    ),
                            ),
                    )
                    ->render(),
            ];
            yield "{$label}: Toggle (variant: ToggleVariant::MENU)" => [
                $theme,
                new ComponentContext(ComponentName::TOGGLE, variant: ToggleVariant::MENU),
                new ComponentContext('toggle', variant: 'menu'),
                $menuToggleRecipes,
                static fn(Config $config, ComponentContext $context): string => Toggle::tag()
                    ->config($config, $context)
                    ->dataAttributes(['bs-target' => '#main-menu'])
                    ->render(),
            ];
            yield "{$label}: Toggle (variant: ToggleVariant::MENU_DROPDOWN)" => [
                $theme,
                new ComponentContext(ComponentName::TOGGLE, variant: ToggleVariant::MENU_DROPDOWN),
                new ComponentContext('toggle', variant: 'menu-dropdown'),
                ["{$name}.toggle.menu-dropdown"],
                static fn(Config $config, ComponentContext $context): string => Toggle::tag()
                    ->config($config, $context)
                    ->content('Docs')
                    ->render(),
            ];
            yield "{$label}: Toggle (variant: ToggleVariant::SELECTOR_THEME)" => [
                $theme,
                new ComponentContext(ComponentName::TOGGLE, variant: ToggleVariant::SELECTOR_THEME),
                new ComponentContext('toggle', variant: 'selector-theme'),
                ["{$name}.toggle.selector-theme"],
                static fn(Config $config, ComponentContext $context): string => Toggle::tag()
                    ->config($config, $context)
                    ->id('theme-selector')
                    ->render(),
            ];
        }
    }
}
