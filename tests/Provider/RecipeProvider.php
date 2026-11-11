<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Provider;

use UIAwesome\Html\Core\Config\ComponentContext;
use UIAwesome\Html\Core\Theme\ThemeInterface;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};

/**
 * Provides the supported semantic contexts and their stable diagnostic recipe names.
 *
 * Alert variants come from {@see ThemeProvider::alertVariants()}; Bootstrap 6 additionally resolves the neutral alert,
 * which has no variant.
 */
final class RecipeProvider
{
    /**
     * Components both themes resolve without a variant.
     */
    private const array COMPONENTS = [
        'breadcrumb',
        'dropdown',
        'navbar',
        'field',
        'field.label',
        'field.hint',
        'field.error',
        'field.control.email',
        'field.control.password',
        'field.control.text',
        'field.control.textarea',
        'field.control.select',
        'field.control.checkbox',
        'field.control.radio',
        'field.control.checkbox-list',
        'field.control.radio-list',
        'field.input-container.checkbox',
        'field.input-container.radio',
        'field.label.checkbox',
        'field.label.radio',
    ];

    /**
     * Theme identifiers mapped to the theme class and to its alert variants beyond the shared contextual ones.
     */
    private const array THEMES = [
        'bootstrap5' => [Bootstrap5Theme::class, []],
        'bootstrap6' => [Bootstrap6Theme::class, [null]],
    ];

    /**
     * Component variants both themes resolve, keyed by component.
     */
    private const array VARIANTS = [
        'dropdown' => 'language',
        'navbar' => 'align-right',
        'toggle' => 'selector-theme',
    ];

    /**
     * @return iterable<string, array{class-string<ThemeInterface>, ComponentContext, string}>
     */
    public static function supported(): iterable
    {
        foreach (self::THEMES as $name => [$theme, $neutralAlertVariants]) {
            foreach (self::COMPONENTS as $component) {
                $expected = "{$name}.{$component}";

                yield $expected => [
                    $theme,
                    new ComponentContext($component),
                    $expected,
                ];
            }

            foreach (self::VARIANTS as $component => $variant) {
                $expected = "{$name}.{$component}.{$variant}";

                yield $expected => [
                    $theme,
                    new ComponentContext($component, variant: $variant),
                    $expected,
                ];
            }

            foreach ([...ThemeProvider::alertVariants($name), ...$neutralAlertVariants] as $variant) {
                $expected = "{$name}.alert" . ($variant === null ? '' : ".{$variant}");

                yield $expected => [
                    $theme,
                    new ComponentContext('alert', variant: $variant),
                    $expected,
                ];
                yield "{$expected}.dismissible" => [
                    $theme,
                    new ComponentContext('alert', variant: $variant, states: ['dismissible']),
                    "{$expected}.dismissible",
                ];
            }
        }

        yield 'bootstrap5.toggle.menu' => [
            Bootstrap5Theme::class,
            new ComponentContext('toggle', variant: 'menu'),
            'bootstrap5.toggle.menu',
        ];
    }
}
