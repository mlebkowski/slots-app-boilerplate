<?php

declare(strict_types=1);

namespace Enraged\Values;

class Assertion extends \Assert\Assertion
{
    public static function ulid(Ulid|string $value, string $message = null, string $propertyPath = null) : bool
    {
        if ($value instanceof Ulid) {
            static::true(Ulid::isValid((string) $value), $message, $propertyPath);

            return true;
        }
        static::true(Ulid::isValid($value), $message, $propertyPath);

        return true;
    }
}
