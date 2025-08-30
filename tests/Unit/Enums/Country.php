<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Country;

it('can give the right country code', function (): void {
    expect(Country::SRI_LANKA->code())->toBe('LK');
});
