<?php

declare(strict_types=1);

namespace UIAwesome\Html\Theme\Bootstrap\Tests\Support;

use UIAwesome\FormModel\BaseFormModel;

/**
 * Form model for component rendering and theme contract tests.
 */
final class DemoForm extends BaseFormModel
{
    public string $email = 'not-an-email';
    public string $password = '';

    /**
     * @return array<string, string>
     */
    public function __debugInfo(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    /**
     * @return array<string, string>
     */
    public function getHints(): array
    {
        return [
            'email' => 'We never share your address.',
            'password' => 'Use at least twelve characters.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function getLabels(): array
    {
        return [
            'email' => 'Email address',
            'password' => 'Password',
        ];
    }
}
