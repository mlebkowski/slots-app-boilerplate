<?php

declare(strict_types=1);

namespace Enraged\Tests\Context\Project;

trait InfrastructureContextTrait
{
    public function infrastructure() : InfrastructureContext
    {
        return new InfrastructureContext($this->getContainer());
    }
}
