<?php

use \Laravel\Lumen\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;
    private $table = 'categories';

    public function testApi()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }

    public function testDatabase()
    {
        $this->seeInDatabase( $this->table, ['id' => 1]);
    }

}
