<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use UIAwesome\Html\Core\Theme\ThemeInterface;
use UIAwesome\Html\Form\{CheckboxList, RadioList};
use UIAwesome\Html\Theme\{Bootstrap5, Bootstrap6};
use UIAwesome\Html\Theme\Tests\ThemeContractTest;

use function sprintf;

/**
 * Provides version-specific rendering scenarios and expectations for {@see ThemeContractTest}.
 *
 * Expectation maps pair each expected (or forbidden) markup fragment with the failure message of its assertion.
 */
final class ThemeProvider
{
    /**
     * Alert variants resolved by both Bootstrap 5 and Bootstrap 6.
     */
    private const array SHARED_ALERT_VARIANTS = [
        'danger',
        'info',
        'primary',
        'secondary',
        'success',
        'warning',
    ];

    /**
     * @return iterable<
     *     string,
     *     array{
     *         ThemeInterface,
     *         string,
     *         list<string>,
     *         int,
     *         array<non-empty-string, string>,
     *         array<non-empty-string, string>,
     *     },
     * >
     */
    public static function alerts(): iterable
    {
        $themes = [
            'bootstrap5' => [
                new Bootstrap5(),
                'alert alert-%s',
                [],
            ],
            'bootstrap6' => [
                new Bootstrap6(),
                'alert theme-%s',
                [
                    'alert-dismissible' => 'Bootstrap 5 dismissible class must not leak.',
                    'fade show' => 'Bootstrap 5 transition classes must not leak.',
                ],
            ],
        ];

        foreach ($themes as $name => [$theme, $class, $notContains]) {
            foreach (self::alertVariants($name) as $variant) {
                $contains = [sprintf($class, $variant) => 'Variant class must be applied.'];

                yield "{$name}.{$variant}.0" => [
                    $theme,
                    $variant,
                    [],
                    0,
                    $contains,
                    $notContains,
                ];
                yield "{$name}.{$variant}.1" => [
                    $theme,
                    $variant,
                    ['dismissible'],
                    1,
                    [...$contains, 'aria-label="Close"' => 'Dismiss button must be labelled.'],
                    $notContains,
                ];
            }
        }
    }

    /**
     * Returns the contextual alert variants the theme resolves, shared variants first.
     *
     * The Bootstrap 6 neutral alert has no variant and is not included.
     *
     * @param 'bootstrap5'|'bootstrap6' $theme Theme identifier.
     *
     * @return list<string> Contextual alert variants.
     */
    public static function alertVariants(string $theme): array
    {
        return match ($theme) {
            'bootstrap5' => [
                ...self::SHARED_ALERT_VARIANTS,
                'dark',
                'light',
            ],
            'bootstrap6' => [
                ...self::SHARED_ALERT_VARIANTS,
                'accent',
                'inverse',
            ],
        };
    }

    /**
     * @return iterable<
     *     string,
     *     array{ThemeInterface, array<non-empty-string, string>, array<non-empty-string, array{int, string}>},
     * >
     */
    public static function breadcrumbs(): iterable
    {
        yield 'Bootstrap 5' => [
            new Bootstrap5(),
            ['class="breadcrumb-item active"' => 'Active item class must be applied.'],
            [],
        ];
        yield 'Bootstrap 6 alpha' => [
            new Bootstrap6(),
            [
                'class="breadcrumb-link active"' => 'Active link class must be applied.',
                '<span class="breadcrumb-link active"' => 'Current item must render as a `span`.',
            ],
            [
                'class="breadcrumb-divider d-flex align-items-center"' => [
                    1,
                    'Exactly one divider must separate two items.',
                ],
            ],
        ];
    }

    /**
     * @return iterable<string, array{ThemeInterface, string, CheckboxList|RadioList, string}>
     */
    public static function choiceLists(): iterable
    {
        $bootstrap5 = new Bootstrap5();
        $bootstrap6 = new Bootstrap6();

        yield 'Bootstrap 5 checkbox-list' => [
            $bootstrap5,
            'checkbox-list',
            CheckboxList::tag(),
            'form-check-input',
        ];
        yield 'Bootstrap 5 radio-list' => [
            $bootstrap5,
            'radio-list',
            RadioList::tag(),
            'form-check-input',
        ];
        yield 'Bootstrap 6 alpha checkbox-list' => [
            $bootstrap6,
            'checkbox-list',
            CheckboxList::tag(),
            'check',
        ];
        yield 'Bootstrap 6 alpha radio-list' => [
            $bootstrap6,
            'radio-list',
            RadioList::tag(),
            'radio',
        ];
    }

    /**
     * @return iterable<string, array{ThemeInterface, string, array<non-empty-string, string>}>
     */
    public static function controls(): iterable
    {
        $themes = [
            'bootstrap5' => [
                new Bootstrap5(),
                ['select' => 'form-select', 'checkbox' => 'form-check-input', 'radio' => 'form-check-input'],
            ],
            'bootstrap6' => [
                new Bootstrap6(),
                ['select' => 'form-control', 'checkbox' => 'check', 'radio' => 'radio'],
            ],
        ];

        foreach ($themes as $name => [$theme, $classes]) {
            foreach (['text', 'email', 'password', 'textarea', 'select', 'checkbox', 'radio'] as $type) {
                yield "{$name}.{$type}" => [
                    $theme,
                    $type,
                    ['class="' . ($classes[$type] ?? 'form-control') => 'Control class must match the control type.'],
                ];
            }

            foreach (['checkbox-list', 'radio-list'] as $type) {
                yield "{$name}.{$type}" => [$theme, $type, []];
            }
        }
    }

    /**
     * @return iterable<
     *     string,
     *     array{ThemeInterface, string|null, array<non-empty-string, string>, array<non-empty-string, string>},
     * >
     */
    public static function dropdowns(): iterable
    {
        $bootstrap5 = new Bootstrap5();
        $bootstrap6 = new Bootstrap6();

        $bootstrap6Contains = [
            'data-bs-toggle="menu"' => 'Toggle must target the JS plugin.',
            'class="menu-item disabled"' => 'Disabled item class must be applied.',
        ];
        $bootstrap6NotContains = ['dropdown-menu' => 'Bootstrap 5 menu class must not leak.'];

        foreach ([null, 'language'] as $variant) {
            yield 'Bootstrap 5 ' . ($variant ?? 'default') => [
                $bootstrap5,
                $variant,
                ['data-bs-toggle="dropdown"' => 'Toggle must target the JS plugin.'],
                [],
            ];
        }

        yield 'Bootstrap 6 alpha default' => [
            $bootstrap6,
            null,
            [...$bootstrap6Contains, 'class="menu-item active"' => 'Active item class must be applied.'],
            $bootstrap6NotContains,
        ];
        yield 'Bootstrap 6 alpha language' => [
            $bootstrap6,
            'language',
            [
                ...$bootstrap6Contains,
                'class="menu-item d-flex align-items-center active"' => 'Active item class must be applied.',
                'data-bs-placement="top-end"' => 'Menu placement must be set.',
            ],
            $bootstrap6NotContains,
        ];
    }

    /**
     * @return iterable<
     *     string,
     *     array{ThemeInterface, string|null, array<non-empty-string, string>, array<non-empty-string, string>},
     * >
     */
    public static function navbars(): iterable
    {
        $themes = [
            'Bootstrap 5' => [
                new Bootstrap5(),
                [
                    'navbar-expand-lg' => 'Expand breakpoint class must be applied.',
                    'data-bs-toggle="dropdown"' => 'Nested toggle must target the dropdown plugin.',
                ],
                [],
            ],
            'Bootstrap 6 alpha' => [
                new Bootstrap6(),
                [
                    'navbar navbar-expand' => 'Expand class must be applied.',
                    'data-bs-toggle="menu"' => 'Nested toggle must target the menu plugin.',
                ],
                [
                    'collapse' => 'Collapse markup must not be rendered.',
                    'drawer' => 'Drawer markup must not be rendered.',
                ],
            ],
        ];

        foreach ($themes as $label => [$theme, $contains, $notContains]) {
            foreach ([null, 'align-right'] as $variant) {
                yield "{$label} " . ($variant ?? 'default') => [$theme, $variant, $contains, $notContains];
            }
        }
    }

    /**
     * @return iterable<string, array{ThemeInterface}>
     */
    public static function themes(): iterable
    {
        yield 'Bootstrap 5' => [new Bootstrap5()];
        yield 'Bootstrap 6 alpha' => [new Bootstrap6()];
    }
}
