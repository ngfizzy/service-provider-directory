<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_service_provider_index_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        // Assert Inertia component and props
        $response->assertInertia(fn ($page) =>
            $page->component('Index')
                 ->has('serviceProviders')
                 ->where('filters', [])
        );
        
    }

    /** @test */
    public function it_can_filter_service_providers_by_category()
    {
        $categoryA = Category::factory()->create(['name' => 'Design']);
        $categoryB = Category::factory()->create(['name' => 'Development']);

        $providerA = ServiceProvider::factory()->create(['category_id' => $categoryA->id]);
        $providerB = ServiceProvider::factory()->create(['category_id' => $categoryB->id]);

        $response = $this->get('/?category_id=' . $categoryA->id);

        $response->assertSee($providerA->name);
        $response->assertDontSee($providerB->name);
    }

    /** @test */
    public function it_displays_the_service_provider_detail_page()
    {
        $provider = ServiceProvider::factory()->create();

        $response = $this->get('/' . $provider->id);

        $response->assertStatus(200);
        $response->assertSee($provider->name);
        $response->assertSee($provider->short_description);
    }
}
