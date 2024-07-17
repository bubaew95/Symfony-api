<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Symfony\Set\SymfonySetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
    ])
    ->withSymfonyContainerXml(__DIR__ . '/var/cache/dev/App_KernelDevDebugContainer.xml')
    ->withSets([
        SymfonySetList::SYMFONY_62,
        SymfonySetList::SYMFONY_CODE_QUALITY,
        SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
    ])
    ->withSkip([
        __DIR__ . '/.git',
        __DIR__ . '/node_modules',
        __DIR__ . '/vendor',
        __DIR__ . '/src/Kernel.php',
        __DIR__ . '/src/Migrations',
    ])
    ->withPhpSets(php82: true)
    ->withPreparedSets(
        deadCode: true, codeQuality: true, typeDeclarations: true
    )
    ->withImportNames();
