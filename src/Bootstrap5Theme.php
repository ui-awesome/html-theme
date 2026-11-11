<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap;

use UIAwesome\Html\Core\Component\Toggle;
use UIAwesome\Html\Core\Config\{Call, ComponentContext, Cookbook, Recipe};
use UIAwesome\Html\Core\Theme\ThemeInterface;
use UIAwesome\Html\Interop\{Block, Inline};
use UIAwesome\Html\Svg\Svg;

use function in_array;

/**
 * Resolves Bootstrap 5 config recipes for the UI Awesome semantic component contexts.
 *
 * Dispatch is explicit: {@see getRecipes()} matches `$context->component`, then narrows on `$context->variant` and
 * `$context->states` where the framework offers more than one presentation. A context the theme does not recognize
 * yields no recipe, so the host component keeps its own defaults.
 *
 * Every alert requires a contextual variant, and the navbar collapses below the large breakpoint behind the `toggle`
 * recipe with the `menu` variant. Interactive alerts, dropdowns, and collapses require Bootstrap's JavaScript; the
 * theme neither loads scripts nor implements color-mode switching.
 *
 * @see https://getbootstrap.com/docs/5.3/getting-started/introduction/
 */
final class Bootstrap5Theme implements ThemeInterface
{
    /**
     * Contextual alert types shipped by Bootstrap 5.
     */
    private const array ALERT_VARIANTS = [
        'danger',
        'dark',
        'info',
        'light',
        'primary',
        'secondary',
        'success',
        'warning',
    ];
    /**
     * Icon collection resolved through {@see Svg::icon()} and {@see Svg::iconPath()}.
     *
     * The `ui-awesome/html-svg` package bundles the `globe`, `moon`, and `sun` glyphs used by this theme under this
     * collection.
     */
    private const string ICON_COLLECTION = 'Bootstrap5';
    /**
     * Stable theme identifier, also used as the recipe-name prefix.
     */
    private const string NAME = 'bootstrap5';

    /**
     * Returns the stable theme identifier used in diagnostics and as the recipe-name prefix.
     *
     * Usage example:
     * ```php
     * $name = (new \UIAwesome\Html\Theme\Bootstrap\Bootstrap5Theme())->getName();
     * ```
     *
     * @return string Stable theme identifier.
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * Returns the recipe resolved for the semantic component context, or nothing when the theme has no opinion.
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return iterable<Recipe> Zero or one recipe, in application order.
     */
    public function getRecipes(ComponentContext $context): iterable
    {
        $recipe = match ($context->component) {
            'alert' => $this->alert($context),
            'breadcrumb' => $this->breadcrumb(),
            'dropdown' => $this->dropdown($context),
            'navbar' => $this->navBar($context),
            'toggle' => $this->toggle($context),
            'field' => $this->field(),
            'field.label' => $this->fieldLabel(),
            'field.control.email',
            'field.control.password',
            'field.control.text',
            'field.control.textarea' => $this->fieldControl($context->component, 'form-control'),
            'field.control.select' => $this->fieldControl($context->component, 'form-select'),
            'field.control.checkbox',
            'field.control.radio' => $this->fieldControl($context->component, 'form-check-input'),
            'field.control.checkbox-list',
            'field.control.radio-list' => $this->fieldChoiceList($context->component),
            'field.input-container.checkbox',
            'field.input-container.radio' => $this->fieldChoiceInputContainer($context->component),
            'field.label.checkbox',
            'field.label.radio' => $this->fieldChoiceLabel($context->component),
            'field.hint' => $this->fieldHint(),
            'field.error' => $this->fieldError(),
            default => null,
        };

        if ($recipe !== null) {
            yield $recipe;
        }
    }

    /**
     * Returns the alert recipe for the contextual variant, adding the close toggle for the `dismissible` state.
     *
     * Bootstrap 5 has no colorless alert, so a missing or unknown variant yields no recipe.
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return Recipe|null Resolved recipe, or `null` when the variant is missing or unknown.
     *
     * @see https://getbootstrap.com/docs/5.3/components/alerts/
     */
    private function alert(ComponentContext $context): Recipe|null
    {
        $variant = $context->variant;

        if ($variant === null || in_array($variant, self::ALERT_VARIANTS, true) === false) {
            return null;
        }

        $class = "alert alert-{$variant}";
        $suffix = "alert.{$variant}";

        if ($context->hasState('dismissible') === false) {
            return $this->recipe($suffix, new Call('class', $class));
        }

        return $this->recipe(
            "{$suffix}.dismissible",
            new Call('class', "{$class} alert-dismissible fade show"),
            new Call('toggle', $this->alertToggle()),
        );
    }

    /**
     * Returns the close button rendered inside a dismissible alert.
     *
     * @return Toggle Close button wired to the Bootstrap alert plugin through `data-bs-dismiss`.
     *
     * @see https://getbootstrap.com/docs/5.3/components/alerts/#dismissing
     */
    private function alertToggle(): Toggle
    {
        return Toggle::tag()
            ->ariaAttributes(['label' => 'Close'])
            ->class('btn-close')
            ->dataAttributes(['bs-dismiss' => 'alert']);
    }

    /**
     * Returns the breadcrumb recipe styling the list, its items, and the active item.
     *
     * @return Recipe Breadcrumb recipe.
     *
     * @see https://getbootstrap.com/docs/5.3/components/breadcrumb/
     */
    private function breadcrumb(): Recipe
    {
        return $this->recipe(
            'breadcrumb',
            new Call('listClass', 'breadcrumb'),
            new Call('listItemActiveClass', 'breadcrumb-item active'),
            new Call('listItemAriaCurrent'),
            new Call('listItemClass', 'breadcrumb-item'),
        );
    }

    /**
     * Returns the dropdown recipe for the requested variant.
     *
     * A missing variant selects the standard dropdown; `language` selects the language switcher. Any other variant
     * yields no recipe.
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return Recipe|null Resolved recipe, or `null` when the variant is unknown.
     *
     * @see https://getbootstrap.com/docs/5.3/components/dropdowns/
     */
    private function dropdown(ComponentContext $context): Recipe|null
    {
        if ($context->variant === null) {
            return $this->recipe(
                'dropdown',
                new Call('containerClass', 'dropdown'),
                new Call('containerTag', Block::DIV),
                new Call('linkClass', 'dropdown-item'),
                new Call('listClass', 'dropdown-menu'),
                new Call('toggle', $this->dropdownToggle()),
            );
        }

        if ($context->variant === 'language') {
            return $this->recipe(
                'dropdown.language',
                new Call('containerClass', 'btn-group dropup ms-3'),
                new Call('containerTag', Block::DIV),
                new Call('linkActiveClass', 'dropdown-item d-flex align-items-center active'),
                new Call('linkClass', 'dropdown-item d-flex align-items-center'),
                new Call('listClass', 'dropdown-menu dropdown-menu-end shadow'),
                new Call('toggle', $this->languageSelectorToggle()),
            );
        }

        return null;
    }

    /**
     * Returns the button that opens a standard dropdown menu.
     *
     * @return Toggle Button wired to the Bootstrap dropdown plugin through `data-bs-toggle`.
     *
     * @see https://getbootstrap.com/docs/5.3/components/dropdowns/
     */
    private function dropdownToggle(): Toggle
    {
        return Toggle::tag()
            ->ariaAttributes(['expanded' => 'false'])
            ->class('btn btn-secondary dropdown-toggle')
            ->content('Dropdown button')
            ->dataAttributes(['bs-toggle' => 'dropdown']);
    }

    /**
     * Returns the field recipe spacing the field wrapper and naming the validation state classes.
     *
     * @return Recipe Field wrapper recipe.
     *
     * @see https://getbootstrap.com/docs/5.3/forms/validation/
     */
    private function field(): Recipe
    {
        return $this->recipe(
            'field',
            new Call('containerClass', 'mb-3'),
            new Call('invalidClass', 'is-invalid'),
            new Call('validClass', 'is-valid'),
        );
    }

    /**
     * Returns the field layout recipe wrapping a single checkbox or radio in a Bootstrap form-check container.
     *
     * @param string $component Semantic component identifier used as the recipe-name suffix.
     *
     * @return Recipe Input container recipe.
     *
     * @see https://getbootstrap.com/docs/5.3/forms/checks-radios/
     */
    private function fieldChoiceInputContainer(string $component): Recipe
    {
        return $this->recipe(
            $component,
            new Call('inputContainerClass', 'form-check'),
            new Call('inputContainerTag', Block::DIV),
        );
    }

    /**
     * Returns the field label recipe for a single checkbox or radio.
     *
     * @param string $component Semantic component identifier used as the recipe-name suffix.
     *
     * @return Recipe Choice label recipe.
     *
     * @see https://getbootstrap.com/docs/5.3/forms/checks-radios/
     */
    private function fieldChoiceLabel(string $component): Recipe
    {
        return $this->recipe($component, new Call('labelClass', 'form-check-label', true));
    }

    /**
     * Returns the recipe presenting every checkbox or radio list item as a Bootstrap form-check.
     *
     * @param string $component Semantic component identifier used as the recipe-name suffix.
     *
     * @return Recipe Choice list recipe.
     *
     * @see https://getbootstrap.com/docs/5.3/forms/checks-radios/
     */
    private function fieldChoiceList(string $component): Recipe
    {
        return $this->recipe(
            $component,
            new Call('itemAttributes', ['class' => 'form-check-input']),
            new Call('itemContainerClass', 'form-check'),
            new Call('itemContainerTag', Block::DIV),
            new Call('itemLabelClass', 'form-check-label'),
        );
    }

    /**
     * Returns the recipe adding the Bootstrap form-control class to a single form control.
     *
     * @param string $component Semantic component identifier used as the recipe-name suffix.
     * @param string $class CSS class serialized on the control.
     *
     * @return Recipe Control recipe.
     *
     * @see https://getbootstrap.com/docs/5.3/forms/form-control/
     */
    private function fieldControl(string $component, string $class): Recipe
    {
        return $this->recipe($component, new Call('class', $class));
    }

    /**
     * Returns the field error recipe rendering the message as Bootstrap validation feedback.
     *
     * @return Recipe Error message recipe.
     *
     * @see https://getbootstrap.com/docs/5.3/forms/validation/
     */
    private function fieldError(): Recipe
    {
        return $this->recipe('field.error', new Call('errorClass', 'invalid-feedback d-block'));
    }

    /**
     * Returns the field hint recipe rendering the hint as Bootstrap form text.
     *
     * @return Recipe Hint recipe.
     *
     * @see https://getbootstrap.com/docs/5.3/forms/form-control/#form-text
     */
    private function fieldHint(): Recipe
    {
        return $this->recipe('field.hint', new Call('hintClass', 'form-text'));
    }

    /**
     * Returns the field label recipe.
     *
     * @return Recipe Label recipe.
     *
     * @see https://getbootstrap.com/docs/5.3/forms/form-control/
     */
    private function fieldLabel(): Recipe
    {
        return $this->recipe('field.label', new Call('labelClass', 'form-label'));
    }

    /**
     * Returns the button that opens a language dropdown, prefixed with the bundled globe icon.
     *
     * @return Toggle Button wired to the Bootstrap dropdown plugin through `data-bs-toggle`.
     *
     * @see https://getbootstrap.com/docs/5.3/components/dropdowns/
     */
    private function languageSelectorToggle(): Toggle
    {
        return Toggle::tag()
            ->ariaAttributes(['expanded' => 'false', 'label' => 'Toggle language dropdown'])
            ->class('btn btn-primary dropdown-toggle d-flex align-items-center text-white')
            ->dataAttributes(['bs-toggle' => 'dropdown'])
            ->iconAttributes(['height' => '32', 'width' => '32'])
            ->iconFilePath(Svg::iconPath(self::ICON_COLLECTION . ':globe'))
            ->iconTag('svg')
            ->title('Select language');
    }

    /**
     * Returns the navbar link that opens a nested dropdown.
     *
     * @return Toggle Link wired to the Bootstrap dropdown plugin through `data-bs-toggle`.
     *
     * @see https://getbootstrap.com/docs/5.3/components/navbar/#nav
     */
    private function menuDropdownToggle(): Toggle
    {
        return Toggle::tag()
            ->ariaAttributes(['expanded' => 'false'])
            ->class('nav-link dropdown-toggle')
            ->content('Dropdown')
            ->dataAttributes(['bs-toggle' => 'dropdown'])
            ->link()
            ->role('button');
    }

    /**
     * Returns the collapse button (hamburger) opening the navbar menu.
     *
     * The caller supplies `data-bs-target` and `aria-controls`, because only the caller knows the identifier of the
     * collapsible element the Bootstrap collapse plugin must locate.
     *
     * @return Recipe Menu toggle recipe.
     *
     * @see https://getbootstrap.com/docs/5.3/components/navbar/#toggler
     */
    private function menuToggle(): Recipe
    {
        return $this->recipe(
            'toggle.menu',
            new Call('ariaAttributes', ['expanded' => 'false', 'label' => 'Toggle navigation']),
            new Call('class', 'navbar-toggler'),
            new Call('dataAttributes', ['bs-toggle' => 'collapse']),
            new Call('toggleClass', 'navbar-toggler-icon'),
            new Call('toggleTag', Inline::SPAN),
        );
    }

    /**
     * Returns the navbar recipe for the requested variant.
     *
     * A missing variant selects the expand-on-large layout; `align-right` pushes the menu to the end of the container.
     * Any other variant yields no recipe. Neither variant wires a collapse toggle: apply the `toggle` context with the
     * `menu` variant and supply the collapse target explicitly.
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return Recipe|null Resolved recipe, or `null` when the variant is unknown.
     *
     * @see https://getbootstrap.com/docs/5.3/components/navbar/
     */
    private function navBar(ComponentContext $context): Recipe|null
    {
        if ($context->variant === null) {
            return $this->recipe(
                'navbar',
                new Call('brandLinkClass', 'navbar-brand'),
                new Call('class', 'navbar navbar-expand-lg bg-body-tertiary'),
                new Call('containerMenuClass', 'container-fluid'),
                new Call('containerMenuTag', Block::DIV),
                new Call('menuDefaultDefinitions', $this->navBarMenuDefinitions('collapse navbar-collapse')),
            );
        }

        if ($context->variant === 'align-right') {
            return $this->recipe(
                'navbar.align-right',
                new Call('brandLinkClass', 'navbar-brand'),
                new Call('class', 'navbar navbar-expand-lg bg-body-tertiary'),
                new Call('containerMenuClass', 'container'),
                new Call('containerMenuTag', Block::DIV),
                new Call(
                    'menuDefaultDefinitions',
                    $this->navBarMenuDefinitions('collapse justify-content-end navbar-collapse', 'navbar-nav'),
                ),
            );
        }

        return null;
    }

    /**
     * Returns the cookbook-style definitions applied to the menu nested in a navbar.
     *
     * Keys are method names and values follow the {@see \UIAwesome\Html\Core\Factory\SimpleFactory} convention: a bare
     * value is a single argument, an array is the ordered argument list, and an empty array calls the method with its
     * own defaults.
     *
     * @param string $class CSS classes of the collapsible menu wrapper.
     * @param string $listClass CSS classes of the menu list.
     *
     * @return array<string, mixed> Cookbook-style definitions for the nested menu.
     */
    private function navBarMenuDefinitions(string $class, string $listClass = 'navbar-nav me-auto mb-2 mb-lg-0'): array
    {
        return [
            'class' => $class,
            'dropdownDefaultDefinitions' => [
                [
                    'linkClass' => 'dropdown-item',
                    'listClass' => 'dropdown-menu',
                    'toggle' => $this->menuDropdownToggle(),
                ],
            ],
            'linkActiveClass' => 'nav-link active',
            'linkAriaCurrent' => [],
            'linkClass' => 'nav-link',
            'linkDisabledClass' => 'nav-link disabled',
            'listClass' => $listClass,
            'listDropdownItemClass' => 'nav-item dropdown',
            'listItemClass' => 'nav-item',
        ];
    }

    /**
     * Returns a recipe named after the theme whose cookbook applies the given calls.
     *
     * @param string $suffix Recipe-name suffix appended to the theme identifier, usually the semantic context.
     * @param Call ...$calls Configuration calls, in application order.
     *
     * @return Recipe Recipe named `bootstrap5.<suffix>`.
     */
    private function recipe(string $suffix, Call ...$calls): Recipe
    {
        return new Recipe(self::NAME . ".{$suffix}", new Cookbook(...$calls));
    }

    /**
     * Returns the light/dark mode switcher carrying the bundled moon and sun icons.
     *
     * Both icons start hidden through `d-none`; the application supplies the switching behavior and icon visibility.
     *
     * @return Recipe Theme selector toggle recipe.
     *
     * @see https://getbootstrap.com/docs/5.3/customize/color-modes/
     */
    private function themeSelectorToggle(): Recipe
    {
        return $this->recipe(
            'toggle.selector-theme',
            new Call('class', 'btn ms-2 me-2'),
            new Call(
                'html',
                Svg::icon(self::ICON_COLLECTION . ':moon')
                    ->class('d-none')
                    ->fill('currentColor')
                    ->height(32)
                    ->id('theme-dark-icon')
                    ->width(32),
                "\n",
                Svg::icon(self::ICON_COLLECTION . ':sun')
                    ->class('d-none')
                    ->fill('currentColor')
                    ->height(32)
                    ->id('theme-light-icon')
                    ->width(32),
            ),
            new Call('title', 'Switch light/dark mode'),
        );
    }

    /**
     * Returns the standalone toggle recipe for the requested variant.
     *
     * Only the toggles no component recipe already embeds are resolved here: `menu` and `selector-theme`. The alert,
     * dropdown, language-selector, and navbar-dropdown toggles ship fully configured inside their owning component
     * recipe, so requesting them here yields no recipe.
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return Recipe|null Resolved recipe, or `null` when the variant is not a standalone toggle.
     */
    private function toggle(ComponentContext $context): Recipe|null
    {
        return match ($context->variant) {
            'menu' => $this->menuToggle(),
            'selector-theme' => $this->themeSelectorToggle(),
            default => null,
        };
    }
}
