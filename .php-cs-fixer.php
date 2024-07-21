<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
;
$config = new PhpCsFixer\Config();

return $config->setRules([
    '@Symfony' => true,
    'yoda_style' => false,
    'fully_qualified_strict_types' => true,
    'single_import_per_statement' => true,
])
    ->setFinder($finder)
;
