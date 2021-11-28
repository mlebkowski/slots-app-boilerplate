<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\Exception;

class InfrastructureInvalidAssertionException extends InfrastructureException
{
    private ?string $propertyPath;
    private mixed $value;
    /**
     * @var mixed[]
     */
    private array $constraints;

    /**
     * @param mixed[] $constraints
     */
    public function __construct(string $message, int $code, string $propertyPath = null, mixed $value = null, array $constraints = [])
    {
        parent::__construct($message, $code);

        $this->propertyPath = $propertyPath;
        $this->value = $value;
        $this->constraints = $constraints;
    }

    public function getPropertyPath() : ?string
    {
        return $this->propertyPath;
    }

    public function getValue() : mixed
    {
        return $this->value;
    }

    /**
     * @return mixed[]
     */
    public function getConstraints() : array
    {
        return $this->constraints;
    }
}
