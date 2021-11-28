<?php

declare(strict_types=1);

namespace Enraged\Tests\Context\Project;

trait InfrastructureContextTrait
{
    protected function setUp() : void
    {
        parent::setUp();
        if (method_exists($this, $method = 'setUpDatabase')) {
            $this->{$method}();
        }
    }

    protected function tearDown() : void
    {
        parent::tearDown();
        if (method_exists($this, $method = 'tearDownDatabase')) {
            $this->{$method}();
        }
    }
}
