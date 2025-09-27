<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_address_view()
    {
        $response = $this->get('/address');

        $response->assertStatus(200);
        $response->assertViewIs('address.index');
    }
}