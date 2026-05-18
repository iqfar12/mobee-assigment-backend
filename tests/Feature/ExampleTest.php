<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_a_redirect_to_admin_dashboard()
    {
        $response = $this->get(route('home'));

        $response->assertRedirect('/admin/dashboard');
    }
}
