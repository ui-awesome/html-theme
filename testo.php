<?php

declare(strict_types=1);

use Testo\Application\Config\{ApplicationConfig, FinderConfig, SuiteConfig};

return new ApplicationConfig(
    src: ['src'],
    suites: [
        new SuiteConfig(
            name: 'Bootstrap',
            location: new FinderConfig(
                include: ['tests'],
                exclude: [
                    'tests/Provider',
                    'tests/Support',
                ],
            ),
        ),
    ],
);
