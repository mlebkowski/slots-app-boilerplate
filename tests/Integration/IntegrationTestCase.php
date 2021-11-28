<?php

declare(strict_types=1);

namespace Enraged\Tests\Integration;

use Enraged\Tests\Context\Project\InfrastructureContextTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTestCase extends KernelTestCase
{
    use InfrastructureContextTrait;
}
