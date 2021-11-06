<?php

declare(strict_types=1);

namespace App\Exception\SlotFetcher;

class SlotsFetchingException extends \Exception
{
    public static function fromDoctorIdAndException(int $doctorId, \Exception $exception): self
    {
        return new self(
            message: sprintf(
                'Failed communication with API for doctor with ID: %s with error: %s',
                $doctorId,
                $exception->getMessage()
            ),
            previous: $exception
        );
    }
}
