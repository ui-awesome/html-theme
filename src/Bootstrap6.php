<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme;

use UIAwesome\Html\Core\Component\Toggle;
use UIAwesome\Html\Core\Config\{Call, ComponentContext, Config, Cookbook, Recipe};
use UIAwesome\Html\Core\Theme\ThemeInterface;
use UIAwesome\Html\Interop\Block;
use UIAwesome\Html\Svg\Svg;

use function in_array;

/**
 * Resolves Bootstrap 6.0.0-alpha.1 config recipes for the UI Awesome semantic component contexts.
 *
 * Dispatch is explicit: {@see getRecipes()} matches `$context->component`, then narrows on `$context->variant` and
 * `$context->states` where the framework offers more than one presentation. A context the theme does not recognize
 * yields no recipe, so the host component keeps its own defaults.
 *
 * Navbar recipes are always expanded: the core menu cannot render Bootstrap 6's native dialog drawer structure, so no
 * menu-toggle recipe is supplied. Interactive alerts and menus require Bootstrap's JavaScript ES module; the theme
 * neither loads scripts nor implements color-mode switching. Icons reuse the bundled Bootstrap 5 collection.
 *
 * @see https://getbootstrap.com/docs/6.0/guides/migration/
 */
final class Bootstrap6 implements ThemeInterface
{
    /**
     * Contextual alert types available in the Bootstrap 6 alpha stylesheet.
     */
    private const array ALERT_VARIANTS = [
        'accent',
        'danger',
        'info',
        'inverse',
        'primary',
        'secondary',
        'success',
        'warning',
    ];
    /**
     * Icon collection resolved through {@see Svg::icon()} and {@see Svg::iconPath()}.
     *
     * Bootstrap 6 deliberately reuses the `Bootstrap5` collection: `ui-awesome/html-svg` ships no Bootstrap 6
     * collection, and its `Bootstrap5` collection bundles the `globe`, `moon`, and `sun` glyphs used by this theme.
     */
    private const string ICON_COLLECTION = 'Bootstrap5';
    /**
     * Stable theme identifier, also used as the recipe-name prefix.
     */
    private const string NAME = 'bootstrap6';

    /**
     * Returns the stable theme identifier used in diagnostics and as the recipe-name prefix.
     *
     * Usage example:
     * ```php
     * $name = (new \UIAwesome\Html\Theme\Bootstrap6())->getName();
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
            'field.control.textarea',
            'field.control.select' => $this->fieldControl($context->component, 'form-control'),
            'field.control.checkbox' => $this->fieldControl($context->component, 'check'),
            'field.control.radio' => $this->fieldControl($context->component, 'radio'),
            'field.control.checkbox-list' => $this->fieldChoiceList($context->component, 'check'),
            'field.control.radio-list' => $this->fieldChoiceList($context->component, 'radio'),
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
     * Returns the alert recipe for the neutral or contextual variant, adding the close toggle for the `dismissible`
     * state.
     *
     * A missing variant selects the neutral alert; an unknown variant yields no recipe. Every recipe wraps the content
     * in a `<div>` container.
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return Recipe|null Resolved recipe, or `null` when the variant is unknown.
     *
     * @see https://getbootstrap.com/docs/6.0/components/alert/
     */
    private function alert(ComponentContext $context): Recipe|null
    {
        $variant = $context->variant;

        if ($variant !== null && in_array($variant, self::ALERT_VARIANTS, true) === false) {
            return null;
        }

        $class = $variant === null ? 'alert' : "alert theme-{$variant}";
        $suffix = 'alert' . ($variant === null ? '' : ".{$variant}");

        if ($context->hasState('dismissible') === false) {
            return $this->recipe($suffix, new Call('class', $class), new Call('containerTag', Block::DIV));
        }

        return $this->recipe(
            "{$suffix}.dismissible",
            new Call('class', $class),
            new Call('containerTag', Block::DIV),
            new Call('toggle', $this->alertToggle()),
        );
    }

    /**
     * Returns the close button rendered inside a dismissible alert, placed at the end of the alert's flex layout.
     *
     * @return Toggle Close button wired to the Bootstrap alert plugin through `data-bs-dismiss`.
     *
     * @see https://getbootstrap.com/docs/6.0/components/alert/
     */
    private function alertToggle(): Toggle
    {
        return Toggle::tag()
            ->ariaAttributes(['label' => 'Close'])
            ->class('btn-close ms-auto')
            ->dataAttributes(['bs-dismiss' => 'alert']);
    }

    /**
     * Returns the breadcrumb recipe styling the list, its items, and their links.
     *
     * The active item renders as a `<span>` carrying the active link class, and items are separated by an explicit
     * divider `<span>` hidden from assistive technology.
     *
     * @return Recipe Breadcrumb recipe.
     *
     * @see https://getbootstrap.com/docs/6.0/components/breadcrumb/
     */
    private function breadcrumb(): Recipe
    {
        return $this->recipe(
            'breadcrumb',
            new Call('listClass', 'breadcrumb'),
            new Call('listItemClass', 'breadcrumb-item'),
            new Call('linkClass', 'breadcrumb-link'),
            new Call('linkActiveClass', 'breadcrumb-link active'),
            new Call('linkActiveTag', 'span'),
            new Call('linkAriaCurrent'),
            new Call(
                'separator',
                '<span class="breadcrumb-divider d-flex align-items-center" aria-hidden="true"></span>',
            ),
        );
    }

    /**
     * Returns the dropdown recipe for the requested variant, rendered as a Bootstrap 6 menu.
     *
     * A missing variant selects the standard menu; `language` selects the language switcher. Any other variant yields
     * no recipe.
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return Recipe|null Resolved recipe, or `null` when the variant is unknown.
     *
     * @see https://getbootstrap.com/docs/6.0/components/menu/
     */
    private function dropdown(ComponentContext $context): Recipe|null
    {
        if ($context->variant === null) {
            return $this->recipe(
                'dropdown',
                new Call('containerTag', Block::DIV),
                new Call('linkClass', 'menu-item'),
                new Call('linkActiveClass', 'menu-item active'),
                new Call('linkDisabledClass', 'menu-item disabled'),
                new Call('listClass', 'menu'),
                new Call('toggle', $this->dropdownToggle()),
            );
        }

        if ($context->variant === 'language') {
            return $this->recipe(
                'dropdown.language',
                new Call('containerClass', 'ms-5'),
                new Call('containerTag', Block::DIV),
                new Call('linkClass', 'menu-item d-flex align-items-center'),
                new Call('linkActiveClass', 'menu-item d-flex align-items-center active'),
                new Call('linkDisabledClass', 'menu-item disabled'),
                new Call('listClass', 'menu'),
                new Call('toggle', $this->languageSelectorToggle()),
            );
        }

        return null;
    }

    /**
     * Returns the button that opens a standard menu.
     *
     * @return Toggle Button wired to the Bootstrap menu plugin through `data-bs-toggle`.
     *
     * @see https://getbootstrap.com/docs/6.0/components/menu/
     */
    private function dropdownToggle(): Toggle
    {
        return Toggle::tag()
            ->ariaAttributes(['expanded' => 'false'])
            ->class('btn-solid theme-secondary menu-toggle')
            ->content('Dropdown button')
            ->dataAttributes(['bs-toggle' => 'menu']);
    }

    /**
     * Returns the field recipe spacing the field wrapper and naming the validation state classes.
     *
     * The `mb-5` margin preserves the one-rem field spacing used by the Bootstrap 5 theme.
     *
     * @return Recipe Field wrapper recipe.
     *
     * @see https://getbootstrap.com/docs/6.0/forms/field/
     */
    private function field(): Recipe
    {
        return $this->recipe(
            'field',
            new Call('containerClass', 'form-field mb-5'),
            new Call('invalidClass', 'is-invalid'),
            new Call('validClass', 'is-valid'),
        );
    }

    /**
     * Returns the field layout recipe giving a single checkbox or radio a two-column field grid.
     *
     * @param string $component Semantic component identifier used as the recipe-name suffix.
     *
     * @return Recipe Input container recipe.
     *
     * @see https://getbootstrap.com/docs/6.0/forms/field/
     */
    private function fieldChoiceInputContainer(string $component): Recipe
    {
        return $this->recipe(
            $component,
            new Call('inputContainerClass', 'form-field'),
            new Call('inputContainerTag', Block::DIV),
        );
    }

    /**
     * Returns the field label recipe for a single checkbox or radio.
     *
     * The generic label class is removed so the choice label stays beside its control.
     *
     * @param string $component Semantic component identifier used as the recipe-name suffix.
     *
     * @return Recipe Choice label recipe.
     *
     * @see https://getbootstrap.com/docs/6.0/forms/checkbox/
     */
    private function fieldChoiceLabel(string $component): Recipe
    {
        return $this->recipe($component, new Call('labelRemoveAttribute', 'class'));
    }

    /**
     * Returns the recipe styling each checkbox or radio list item with its own field grid and native control class.
     *
     * @param string $component Semantic component identifier used as the recipe-name suffix.
     * @param string $class CSS class serialized on every list item control.
     *
     * @return Recipe Choice list recipe.
     *
     * @see https://getbootstrap.com/docs/6.0/forms/checkbox/
     * @see https://getbootstrap.com/docs/6.0/forms/radio/
     */
    private function fieldChoiceList(string $component, string $class): Recipe
    {
        return $this->recipe(
            $component,
            new Call('itemAttributes', ['class' => $class]),
            new Call('itemContainerClass', 'form-field'),
            new Call('itemContainerTag', Block::DIV),
        );
    }

    /**
     * Returns the recipe adding the stylesheet class to a single form control.
     *
     * @param string $component Semantic component identifier used as the recipe-name suffix.
     * @param string $class CSS class serialized on the control.
     *
     * @return Recipe Control recipe.
     *
     * @see https://getbootstrap.com/docs/6.0/forms/form-control/
     */
    private function fieldControl(string $component, string $class): Recipe
    {
        return $this->recipe($component, new Call('class', $class));
    }

    /**
     * Returns the field error recipe keeping server-side error messages visible across nested field layouts.
     *
     * @return Recipe Error message recipe.
     *
     * @see https://getbootstrap.com/docs/6.0/forms/validation/
     */
    private function fieldError(): Recipe
    {
        return $this->recipe('field.error', new Call('errorClass', 'invalid-feedback d-block'));
    }

    /**
     * Returns the field hint recipe styling the explanatory text below a field.
     *
     * @return Recipe Hint recipe.
     *
     * @see https://getbootstrap.com/docs/6.0/forms/form-control/
     */
    private function fieldHint(): Recipe
    {
        return $this->recipe('field.hint', new Call('hintClass', 'form-text'));
    }

    /**
     * Returns the field label recipe for ordinary controls and choice groups.
     *
     * @return Recipe Label recipe.
     *
     * @see https://getbootstrap.com/docs/6.0/forms/form-control/
     */
    private function fieldLabel(): Recipe
    {
        return $this->recipe('field.label', new Call('labelClass', 'form-label'));
    }

    /**
     * Returns the button that opens a language menu above its trigger, aligned to the end edge, prefixed with the
     * bundled globe icon.
     *
     * @return Toggle Button wired to the Bootstrap menu plugin through `data-bs-toggle`.
     *
     * @see https://getbootstrap.com/docs/6.0/components/menu/
     */
    private function languageSelectorToggle(): Toggle
    {
        return Toggle::tag()
            ->ariaAttributes(['expanded' => 'false', 'label' => 'Toggle language dropdown'])
            ->class('btn-solid theme-primary menu-toggle d-flex align-items-center')
            ->dataAttributes(['bs-toggle' => 'menu', 'bs-placement' => 'top-end'])
            ->iconAttributes(['height' => '32', 'width' => '32'])
            ->iconFilePath(Svg::iconPath(self::ICON_COLLECTION . ':globe'))
            ->iconTag('svg')
            ->title('Select language');
    }

    /**
     * Returns the navbar link that opens a nested menu, labelled `Dropdown`.
     *
     * The link is built from {@see menuDropdownToggleRecipe()} through this theme, so the navbar default and the
     * standalone `menu-dropdown` toggle share one styling source.
     *
     * @return Toggle Link wired to the Bootstrap menu plugin through `data-bs-toggle`.
     *
     * @see https://getbootstrap.com/docs/6.0/components/navbar/
     */
    private function menuDropdownToggle(): Toggle
    {
        return Toggle::tag()
            ->config(new Config($this), new ComponentContext('toggle', variant: 'menu-dropdown'))
            ->content('Dropdown');
    }

    /**
     * Returns the navbar link styling that opens a nested menu, without content.
     *
     * The link points to `#` so it stays keyboard-focusable; a caller `href` set after the recipe replaces it. The recipe
     * carries no content because `content()` appends: the caller supplies the label.
     *
     * @return Recipe Navbar dropdown toggle recipe.
     *
     * @see https://getbootstrap.com/docs/6.0/components/navbar/
     */
    private function menuDropdownToggleRecipe(): Recipe
    {
        return $this->recipe(
            'toggle.menu-dropdown',
            new Call('addAttribute', 'href', '#'),
            new Call('ariaAttributes', ['expanded' => 'false']),
            new Call('class', 'nav-link menu-toggle'),
            new Call('dataAttributes', ['bs-toggle' => 'menu']),
            new Call('link'),
            new Call('role', 'button'),
        );
    }

    /**
     * Returns the always-expanded navbar recipe for the requested variant.
     *
     * A missing variant selects the fluid layout; `align-right` pushes the menu to the end of the container. Any other
     * variant yields no recipe. Responsive drawers require a native dialog and additional core wrapper support; these
     * recipes do not add them.
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return Recipe|null Resolved recipe, or `null` when the variant is unknown.
     *
     * @see https://getbootstrap.com/docs/6.0/components/navbar/
     */
    private function navBar(ComponentContext $context): Recipe|null
    {
        if ($context->variant === null) {
            return $this->recipe(
                'navbar',
                new Call('brandLinkClass', 'navbar-brand'),
                new Call('class', 'navbar navbar-expand bg-1'),
                new Call('containerMenuClass', 'container-fluid'),
                new Call('containerMenuTag', Block::DIV),
                new Call('menuDefaultDefinitions', $this->navBarMenuDefinitions('flex-grow-1')),
            );
        }

        if ($context->variant === 'align-right') {
            return $this->recipe(
                'navbar.align-right',
                new Call('brandLinkClass', 'navbar-brand'),
                new Call('class', 'navbar navbar-expand bg-1'),
                new Call('containerMenuClass', 'container'),
                new Call('containerMenuTag', Block::DIV),
                new Call('menuDefaultDefinitions', $this->navBarMenuDefinitions('ms-auto')),
            );
        }

        return null;
    }

    /**
     * Returns the cookbook-style definitions applied to the menu nested in a navbar and to its nested menus.
     *
     * Keys are method names and values follow the {@see \UIAwesome\Html\Core\Factory\SimpleFactory} convention: a bare
     * value is a single argument, an array is the ordered argument list, and an empty array calls the method with its
     * own defaults.
     *
     * @param string $class CSS classes of the menu wrapper.
     *
     * @return array<string, mixed> Cookbook-style definitions for the nested menu.
     */
    private function navBarMenuDefinitions(string $class): array
    {
        return [
            'class' => $class,
            'dropdownDefaultDefinitions' => [
                [
                    'linkClass' => 'menu-item',
                    'linkActiveClass' => 'menu-item active',
                    'linkDisabledClass' => 'menu-item disabled',
                    'listClass' => 'menu',
                    'toggle' => $this->menuDropdownToggle(),
                ],
            ],
            'linkActiveClass' => 'nav-link active',
            'linkAriaCurrent' => [],
            'linkClass' => 'nav-link',
            'linkDisabledClass' => 'nav-link disabled',
            'listClass' => 'nav navbar-nav',
            'listDropdownItemClass' => 'nav-item',
            'listItemClass' => 'nav-item',
        ];
    }

    /**
     * Returns a recipe named after the theme whose cookbook applies the given calls.
     *
     * @param string $suffix Recipe-name suffix appended to the theme identifier, usually the semantic context.
     * @param Call ...$calls Configuration calls, in application order.
     *
     * @return Recipe Recipe named `bootstrap6.<suffix>`.
     */
    private function recipe(string $suffix, Call ...$calls): Recipe
    {
        return new Recipe(self::NAME . ".{$suffix}", new Cookbook(...$calls));
    }

    /**
     * Returns the accessible light/dark mode switcher carrying the bundled moon and sun icons.
     *
     * Both icons start hidden through `d-none`; the application supplies the switching behavior and icon visibility.
     *
     * @return Recipe Theme selector toggle recipe.
     */
    private function themeSelectorToggle(): Recipe
    {
        return $this->recipe(
            'toggle.selector-theme',
            new Call('ariaAttributes', ['label' => 'Switch light/dark mode']),
            new Call('class', 'btn ms-3 me-3'),
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
     * Resolves `menu-dropdown` and `selector-theme`. The `menu-dropdown` toggle carries the navbar dropdown styling
     * without content, so the caller supplies the label. The `menu` toggle requires drawer markup the core menu cannot
     * render, and the alert, dropdown, and language-selector toggles ship fully configured inside their owning
     * component recipe, so requesting them here yields no recipe.
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return Recipe|null Resolved recipe, or `null` when the variant is not a standalone toggle.
     */
    private function toggle(ComponentContext $context): Recipe|null
    {
        return match ($context->variant) {
            'menu-dropdown' => $this->menuDropdownToggleRecipe(),
            'selector-theme' => $this->themeSelectorToggle(),
            default => null,
        };
    }
}
