<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = Finder::create()
    ->in(__DIR__)
;

$rules = [
    '@PhpCsFixer' => true,
    'assign_null_coalescing_to_coalesce_equal' => true,
    'attribute_empty_parentheses' => [
        'use_parentheses' => false,
    ],
    'class_attributes_separation' => [
        'elements' => [
            'case' => 'none',
            'const' => 'one',
            'method' => 'one',
            'property' => 'one',
            'trait_import' => 'none',
        ],
    ],
    'combine_nested_dirname' => true,
    'declare_strict_types' => true,
    'dir_constant' => true,
    'echo_tag_syntax' => [
        'format' => 'short',
        'shorten_simple_statements_only' => true,
    ],
    'empty_loop_body' => [
        'style' => 'braces',
    ],
    'empty_loop_condition' => [
        'style' => 'while',
    ],
    'fopen_flag_order' => true,
    'fully_qualified_strict_types' => [
        'import_symbols' => true,
        'leading_backslash_in_global_namespace' => false,
    ],
    'function_to_constant' => true,
    'get_class_to_class_keyword' => true,
    'global_namespace_import' => [
        'import_classes' => true,
        'import_constants' => false,
        'import_functions' => false,
    ],
    'heredoc_indentation' => true,
    'implode_call' => true,
    'is_null' => true,
    'list_syntax' => [
        'syntax' => 'short',
    ],
    'modernize_types_casting' => true,
    'native_constant_invocation' => [
        'fix_built_in' => false,
        'include' => [
            'DIRECTORY_SEPARATOR',
            'PHP_EOL',
            'PHP_INT_SIZE',
            'PHP_SAPI',
            'PHP_VERSION_ID',
        ],
        'scope' => 'namespaced',
        'strict' => true,
    ],
    'native_function_invocation' => [
        'include' => ['@internal'],
        'scope' => 'namespaced',
        'strict' => true,
    ],
    'new_expression_parentheses' => [
        'use_parentheses' => false,
    ],
    'no_redundant_readonly_property' => true,
    'no_useless_sprintf' => true,
    'phpdoc_annotation_without_dot' => false,
    'phpdoc_param_order' => true,
    'phpdoc_tag_casing' => [
        'tags' => ['inheritDoc'],
    ],
    'phpdoc_to_comment' => [
        'ignored_tags' => ['var'],
    ],
    'phpdoc_types_order' => [
        'null_adjustment' => 'always_last',
    ],
    'simplified_if_return' => true,
    'single_line_empty_body' => false,
    'stringable_for_to_string' => true,
    'ternary_to_null_coalescing' => true,
    'type_declaration_spaces' => [
        'elements' => [
            'constant',
            'function',
            'property',
        ],
    ],
    'void_return' => true,
    'yoda_style' => [
        'equal' => false,
        'identical' => false,
        'less_and_greater' => false,
    ],
];

return (new Config())
    ->setCacheFile('.cache/php-cs-fixer/.php-cs-fixer.cache')
    ->setFinder($finder)
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setUsingCache(true)
;
