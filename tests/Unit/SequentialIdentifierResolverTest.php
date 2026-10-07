<?php

declare(strict_types=1);

use BradieTilley\Snowflakes\IdentifierResolvers\SequentialIdentifierResolver;

test('an omitted or null group shares the empty group counter', function (): void {
    $resolver = new SequentialIdentifierResolver();

    expect($resolver->identifier(0, 0))->toBe(SequentialIdentifierResolver::START_ID + 1)
        ->and($resolver->identifier(0, 0, null))->toBe(SequentialIdentifierResolver::START_ID + 2)
        ->and($resolver->identifier(0, 0, ''))->toBe(SequentialIdentifierResolver::START_ID + 3);
});

test('named group counters stay independent and reset together', function (): void {
    $resolver = new SequentialIdentifierResolver();

    expect($resolver->identifier(0, 0, 'users'))->toBe(SequentialIdentifierResolver::START_ID + 1)
        ->and($resolver->identifier(0, 0, 'users'))->toBe(SequentialIdentifierResolver::START_ID + 2)
        ->and($resolver->identifier(0, 0, 'jobs'))->toBe(SequentialIdentifierResolver::START_ID + 1);

    $resolver->reset();

    expect($resolver->identifier(0, 0, 'users'))->toBe(SequentialIdentifierResolver::START_ID + 1)
        ->and($resolver->identifier(0, 0))->toBe(SequentialIdentifierResolver::START_ID + 1);
});
