<?php

namespace Tests\Feature;

use Tests\TestCase;

class AppStatusTest extends TestCase
{

    public function testAPIStatusActive()
    {
        $response = $this->get('/api');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'active'
            ]);
    }
}
