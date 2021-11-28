<?php

declare(strict_types=1);

namespace Enraged\Tests\Functional\Interactions\Web\Controller;

use Enraged\Tests\Functional\FunctionalWebTestCase;

class StatusControllerTest extends FunctionalWebTestCase
{
    public function test_index_html()
    {
        $this->assertEquals(
            'OK',
            $this
                ->createClient()
                ->request('GET', '')
                ->text()
        );
    }
}
