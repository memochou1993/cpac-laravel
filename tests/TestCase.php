<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    protected function setUp()
    {
        parent::setUp();

        //
    }

    public function query($payload)
    {
        return $this->graphql('query', $payload);
    }

    public function mutate($payload) 
    {
        return $this->graphql('mutation', $payload);
    }
    
    protected function graphql($operation, $payload)
    {
        return $this->post('/graphql', [
            'query' => "${operation} { ${payload} }",
        ]);
    }

    protected function tearDown()
    {
        parent::tearDown();

        //
    }
}
