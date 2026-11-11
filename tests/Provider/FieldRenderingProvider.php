<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Provider;

use Closure;
use UIAwesome\Html\Core\Config\Config;
use UIAwesome\Html\Field\Field;
use UIAwesome\Html\Theme\Bootstrap\{Bootstrap5Theme, Bootstrap6Theme};
use UIAwesome\Html\Theme\Bootstrap\Tests\FieldRenderingTest;
use UIAwesome\Html\Theme\Bootstrap\Tests\Support\DemoForm;

/**
 * Provides expected markup and deferred component builders for {@see FieldRenderingTest}.
 */
final class FieldRenderingProvider
{
    /**
     * @return array<string, array{string, Closure(): string}>
     */
    public static function cases(): array
    {
        return [
            'Bootstrap 5: Field (control: email, invalid)' => [
                <<<HTML
                <div class="mb-3">
                <label class="form-label" for="demoform-email">Email address</label>
                <input class="form-control is-invalid" id="demoform-email" name="DemoForm[email]" type="email" value="not-an-email" aria-describedby="demoform-email-help">
                <div class="form-text" id="demoform-email-help">
                We never share your address.
                </div>
                <div class="invalid-feedback d-block">
                This value is not a valid email address.
                </div>
                </div>
                HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5Theme());

                    $formModel = new DemoForm();

                    $formModel->addError('email', 'This value is not a valid email address.');

                    return Field::tag()
                        ->config($config)
                        ->formModel($formModel)
                        ->property('email')
                        ->control('email')
                        ->render();
                },
            ],
            'Bootstrap 5: Field (control: password, pristine)' => [
                <<<HTML
                <div class="mb-3">
                <label class="form-label" for="demoform-password">Password</label>
                <input class="form-control" id="demoform-password" name="DemoForm[password]" type="password" aria-describedby="demoform-password-help">
                <div class="form-text" id="demoform-password-help">
                Use at least twelve characters.
                </div>
                </div>
                HTML,
                static function (): string {
                    $config = new Config(new Bootstrap5Theme());

                    $formModel = new DemoForm();

                    return Field::tag()
                        ->config($config)
                        ->formModel($formModel)
                        ->property('password')
                        ->control('password')
                        ->render();
                },
            ],
            'Bootstrap 6: Field (control: email, invalid)' => [
                <<<HTML
                <div class="form-field mb-5">
                <label class="form-label" for="demoform-email">Email address</label>
                <input class="form-control is-invalid" id="demoform-email" name="DemoForm[email]" type="email" value="not-an-email" aria-describedby="demoform-email-help">
                <div class="form-text" id="demoform-email-help">
                We never share your address.
                </div>
                <div class="invalid-feedback d-block">
                This value is not a valid email address.
                </div>
                </div>
                HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6Theme());

                    $formModel = new DemoForm();

                    $formModel->addError('email', 'This value is not a valid email address.');

                    return Field::tag()
                        ->config($config)
                        ->formModel($formModel)
                        ->property('email')
                        ->control('email')
                        ->render();
                },
            ],
            'Bootstrap 6: Field (control: password, pristine)' => [
                <<<HTML
                <div class="form-field mb-5">
                <label class="form-label" for="demoform-password">Password</label>
                <input class="form-control" id="demoform-password" name="DemoForm[password]" type="password" aria-describedby="demoform-password-help">
                <div class="form-text" id="demoform-password-help">
                Use at least twelve characters.
                </div>
                </div>
                HTML,
                static function (): string {
                    $config = new Config(new Bootstrap6Theme());

                    $formModel = new DemoForm();

                    return Field::tag()
                        ->config($config)
                        ->formModel($formModel)
                        ->property('password')
                        ->control('password')
                        ->render();
                },
            ],
        ];
    }
}
