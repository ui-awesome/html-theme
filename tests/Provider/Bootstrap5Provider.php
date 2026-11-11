<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Tests\Provider;

use UIAwesome\Html\Core\Config\ComponentContext;
use UIAwesome\Html\Interop\Block;

/**
 * Provides choice recipes and validation scenarios for Bootstrap 5.
 */
final class Bootstrap5Provider
{
    /**
     * @return array<string, array{ComponentContext, string, list<array{string, list<mixed>}>}>
     */
    public static function choiceRecipes(): array
    {
        return [
            'checkbox control' => [
                new ComponentContext('field.control.checkbox'),
                'bootstrap5.field.control.checkbox',
                [['class', ['form-check-input']]],
            ],
            'radio control' => [
                new ComponentContext('field.control.radio'),
                'bootstrap5.field.control.radio',
                [['class', ['form-check-input']]],
            ],
            'checkbox input container' => [
                new ComponentContext('field.input-container.checkbox'),
                'bootstrap5.field.input-container.checkbox',
                [
                    ['inputContainerClass', ['form-check']],
                    ['inputContainerTag', [Block::DIV]],
                ],
            ],
            'radio label' => [
                new ComponentContext('field.label.radio'),
                'bootstrap5.field.label.radio',
                [['labelClass', ['form-check-label', true]]],
            ],
            'checkbox list' => [
                new ComponentContext('field.control.checkbox-list'),
                'bootstrap5.field.control.checkbox-list',
                [
                    ['itemAttributes', [['class' => 'form-check-input']]],
                    ['itemContainerClass', ['form-check']],
                    ['itemContainerTag', [Block::DIV]],
                    ['itemLabelClass', ['form-check-label']],
                ],
            ],
            'radio list' => [
                new ComponentContext('field.control.radio-list'),
                'bootstrap5.field.control.radio-list',
                [
                    ['itemAttributes', [['class' => 'form-check-input']]],
                    ['itemContainerClass', ['form-check']],
                    ['itemContainerTag', [Block::DIV]],
                    ['itemLabelClass', ['form-check-label']],
                ],
            ],
        ];
    }

    /**
     * @return iterable<string, array{string, bool}>
     */
    public static function feedback(): iterable
    {
        foreach (['checkbox', 'radio', 'text', 'checkbox-list', 'radio-list'] as $type) {
            foreach ([false, true] as $invalid) {
                yield $type . '.' . (int) $invalid => [$type, $invalid];
            }
        }
    }
}
