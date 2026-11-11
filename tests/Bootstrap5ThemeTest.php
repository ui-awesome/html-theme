<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests;

use RuntimeException;
use Testo\Assert;
use Testo\Data\DataProvider;
use Testo\Filter\Group;
use Testo\Test;
use UIAwesome\Html\Core\Config\{Call, ComponentContext, Config, Recipe};
use UIAwesome\Html\Field\Factory\ControlFactory;
use UIAwesome\Html\Field\Field;
use UIAwesome\Html\Form\{CheckboxList, ChoiceItem, InputCheckbox, InputRadio, RadioList};
use UIAwesome\Html\Interop\Inline;
use UIAwesome\Html\Theme\Bootstrap\Bootstrap5Theme;
use UIAwesome\Html\Theme\Bootstrap\Tests\Provider\Bootstrap5ThemeProvider;
use UIAwesome\Html\Theme\Bootstrap\Tests\Support\DemoForm;

use function array_map;
use function iterator_to_array;
use function str_ends_with;

/**
 * Unit tests for {@see Bootstrap5Theme} recipe resolution and server feedback rendering.
 *
 * {@see Bootstrap5ThemeProvider} for test case data providers.
 */
#[Test]
#[Group('theme')]
final class Bootstrap5ThemeTest
{
    /**
     * @param list<array{string, list<mixed>}> $expectedCalls
     */
    #[DataProvider(Bootstrap5ThemeProvider::class . '::choiceRecipes')]
    public function resolvesChoiceRecipes(
        ComponentContext $context,
        string $expectedName,
        array $expectedCalls,
    ): void {
        $recipe = self::resolveOne($context);

        Assert::same(
            $recipe->name,
            $expectedName,
            'Recipe name must identify its exact semantic context.',
        );
        Assert::same(
            array_map(
                static fn(Call $call): array => [$call->method, $call->arguments],
                $recipe->cookbook->calls,
            ),
            $expectedCalls,
            'Recipe calls and their order must remain stable.',
        );
    }

    public function serverFeedbackAllowsApplicationOverrides(): void
    {
        $model = new DemoForm();

        $model->addError('email', 'Review this choice.');

        $html = Field::tag()
            ->config(new Config(new Bootstrap5Theme()))
            ->control('checkbox')
            ->errorAttributes(['data-feedback' => 'custom'])
            ->errorClass('application-feedback', true)
            ->errorTag(Inline::SPAN)
            ->formModel($model)->property('email')
            ->render();

        Assert::string($html)->contains(
            <<<HTML
            <span class="application-feedback" data-feedback="custom">
            HTML,
            'Application error tag, class and attributes must be applied.',
        );
        Assert::string($html)->contains(
            'Review this choice.',
            'Model error must be rendered.',
        );
        Assert::string($html)->notContains(
            'invalid-feedback',
            'Theme feedback class must be replaced.',
        );
        Assert::string($html)->notContains(
            'd-block',
            'Theme display class must be replaced.',
        );
    }

    #[DataProvider(Bootstrap5ThemeProvider::class . '::feedback')]
    public function serverFeedbackPreservesBoundControl(string $type, bool $invalid): void
    {
        $model = new DemoForm();

        if ($invalid) {
            $model->addError('email', '<img src=x onerror=alert(1)> & &amp;');
        }

        $config = new Config(
            new Bootstrap5Theme(),
            factory: new ControlFactory(
                [
                    'checkbox' => static fn(): InputCheckbox => InputCheckbox::tag()->value('not-an-email'),
                    'radio' => static fn(): InputRadio => InputRadio::tag()->value('not-an-email'),
                    'checkbox-list' => static fn(): CheckboxList => CheckboxList::tag()->items(
                        (new ChoiceItem())->value('other')->label('Other'),
                        (new ChoiceItem())->value('not-an-email')->label('Selected'),
                    ),
                    'radio-list' => static fn(): RadioList => RadioList::tag()->items(
                        (new ChoiceItem())->value('other')->label('Other'),
                        (new ChoiceItem())->value('not-an-email')->label('Selected'),
                    ),
                ],
            ),
        );

        $html = Field::tag()
            ->config($config)
            ->control($type)
            ->formModel($model)
            ->property('email')
            ->render();

        if ($invalid) {
            Assert::string($html)->contains(
                'class="invalid-feedback d-block"',
                'Server feedback must not depend on being a sibling of the invalid input.',
            );
            Assert::string($html)->contains(
                '&lt;img src=x onerror=alert(1)&gt; &amp; &amp;amp;',
                'Model errors must be encoded exactly once.',
            );
        } else {
            Assert::string($html)->notContains(
                'invalid-feedback',
                'Pristine fields must omit feedback.',
            );
        }

        Assert::string($html)->contains(
            'aria-describedby="demoform-email-help"',
            'Control must reference the hint.',
        );
        Assert::string($html)->contains(
            'id="demoform-email-help"',
            'Hint must keep its identifier.',
        );
        Assert::string($html)->contains(
            'We never share your address.',
            'Hint text must be rendered.',
        );
        Assert::string($html)->contains(
            'Email address',
            'Label text must be rendered.',
        );
        Assert::string($html)->contains(
            $type === 'text' ? 'value="not-an-email"' : 'value="not-an-email" checked',
            'The bound value must remain selected.',
        );
        Assert::string($html)->contains(
            str_ends_with($type, '-list') ? 'for="demoform-email-1"' : 'for="demoform-email"',
            'Labels must still target their inputs.',
        );
    }

    private static function resolveOne(ComponentContext $context): Recipe
    {
        $recipes = iterator_to_array((new Bootstrap5Theme())->getRecipes($context));

        Assert::count(
            $recipes,
            1,
            'A supported context must resolve exactly one recipe.',
        );

        return $recipes[0] ?? throw new RuntimeException('The supported context returned no recipe.');
    }
}
