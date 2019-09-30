<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
                ->notPath('Fixtures')
                ->notPath('_generated')
                ->in(
                    [
                    __DIR__.'/src',
                    __DIR__.'/tests'
                  ]
                );

return Config::create()
             ->setRiskyAllowed(true)
             ->setRules(
                 [
                 '@PHP73Migration'                               => true,
                 '@PHP71Migration:risky'                         => true,
                 '@DoctrineAnnotation'                           => true,
                 '@PhpCsFixer'                                   => true,
                 '@PhpCsFixer:risky'                             => true,
                 '@PHPUnit75Migration:risky'                     => true,
                 'array_syntax'                                  => ['syntax' => 'short'],
                 'combine_consecutive_unsets'                    => true,
                 'heredoc_to_nowdoc'                             => true,
                 'list_syntax'                                   => ['syntax' => 'long'],
                 'no_extra_blank_lines'                          => [
                   'break',
                   'continue',
                   'extra',
                   'return',
                   'throw',
                   'use',
                   'parenthesis_brace_block',
                   'square_brace_block',
                   'curly_brace_block',
                 ],
                 'mb_str_functions'                              => true,
                 'new_with_braces'                               => true,
                 'blank_line_after_opening_tag'                  => false,
                 'linebreak_after_opening_tag'                   => false,
                 'no_short_echo_tag'                             => true,
                 'no_unreachable_default_argument_value'         => true,
                 'no_useless_else'                               => true,
                 'no_useless_return'                             => true,
                 'ordered_class_elements'                        => true,
                 'ordered_imports'                               => true,
                 'php_unit_strict'                               => [
                   'assertAttributeEquals',
                   'assertAttributeNotEquals',
                 ],
                 'php_unit_test_class_requires_covers'           => false,
                 'phpdoc_add_missing_param_annotation'           => true,
                 'phpdoc_order'                                  => true,
                 'semicolon_after_instruction'                   => true,
                 'strict_comparison'                             => true,
                 'strict_param'                                  => true,
                 'doctrine_annotation_braces'                    => true,
                 'doctrine_annotation_indentation'               => true,
                 'doctrine_annotation_spaces'                    => true,
                 'visibility_required'                           => ['property', 'method', 'const'],
                 'declare_strict_types'                          => true,
                 'concat_space'                                  => ['spacing' => 'one'],
                 'align_multiline_comment'                       => true,
                 'fully_qualified_strict_types'                  => true,
                 'method_chaining_indentation'                   => true,
                 'native_function_invocation'                    => true,
                 'no_alternative_syntax'                         => true,
                 'php_unit_set_up_tear_down_visibility'          => true,
                 'phpdoc_trim_consecutive_blank_line_separation' => true,
                 'return_assignment'                             => true,
                 'php_unit_test_case_static_method_calls'        => ['call_type' => 'self'],
                 'php_unit_test_annotation'                      => ['style' => 'annotation'],
                 'logical_operators'                             => true,
               ]
             )
             ->setFinder($finder);
