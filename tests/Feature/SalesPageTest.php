<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sales_page_shows_previous_sales_for_authenticated_user()
    {
        // 1. Create a user and log them in
        $user = User::factory()->create();
        $this->actingAs($user);

        // 2. Seed 3 sales for that user
        Sale::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        // 3. Visit the sales page
        $response = $this->get(route('sales.index'));

        // 4. Assertions
        $response->assertStatus(200);
        $response->assertSee('Previous Sales');
        $response->assertSee('£');
        $response->assertSee((string) Sale::first()->quantity);
    }
}
