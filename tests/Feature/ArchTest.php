<?php

declare(strict_types=1);

test('the codebase does not reference env variables outside of config files')
    ->expect('env')
    ->not->toBeUsed();

test('app classes use strict types.')
    ->expect('App')
    ->toUseStrictTypes();

test('the codebase does not contain any debugging code')
    ->expect([
        'dd',
        'dump',
        'var_dump',
        'die',
        'sleep',
        'usleep',
        'exit',
    ])
    ->not->toBeUsed();
