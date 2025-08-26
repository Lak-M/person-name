<?php

declare(strict_types=1);

use Lakm\PersonName\NameBuilders\DefaultBuilder;
use Lakm\PersonName\NameBuilders\SimpleBuilder;


it('extends DefaultBuilder', function (): void {
    expect(SimpleBuilder::class)->toExtend(DefaultBuilder::class);
});

it('can create a person name from constructor', function (): void {
    $firstName = 'david';
    $middleName = 'volt';
    $lastName = 'henry';

    $pn = new SimpleBuilder($firstName, $middleName, $lastName);

    expect($pn->first())->toBe($firstName)
        ->and($pn->middle())->toBe($middleName)
        ->and($pn->last())->toBe($lastName);
});

it('can create a person name from full name', function (): void {
    $fullName = "Dr. Nano  fusis delo Jr. III";

    $n1 = SimpleBuilder::fromFullName($fullName);

    expect($n1)->toBeInstanceOf(DefaultBuilder::class)
        ->and($n1->fullName())->toBe("Dr. Nano fusis delo Jr. III")
        ->and($n1->first())->toBe("Nano")
        ->and($n1->middle())->toBe("fusis")
        ->and($n1->last())->toBe("delo")
        ->and($n1->prefix())->toBe('Dr.')
        ->and($n1->suffix())->toBe("III Jr.");
});
