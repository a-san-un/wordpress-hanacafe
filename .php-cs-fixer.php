<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/wp/wp-content/themes/hanacafe-theme')
    ->exclude('node_modules')
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12'                => true,
        'braces_position'       => [
            'functions_opening_brace'              => 'next_line_unless_newline_at_signature_end',
            'classes_opening_brace'                => 'next_line_unless_newline_at_signature_end',
            'control_structures_opening_brace'     => 'same_line',
            'anonymous_functions_opening_brace'    => 'same_line',
        ],
        'no_closing_tag'        => true,
        'indentation_type'      => true,
    ])
    ->setIndent("\t")
    ->setLineEnding("\n")
    ->setFinder($finder);
