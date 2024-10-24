<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AmenityController
 */
final class AmenityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $amenities = Amenity::factory()->count(3)->create();

        $response = $this->get(route('amenities.index'));

        $response->assertOk();
        $response->assertViewIs('amenity.index');
        $response->assertViewHas('amenities');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('amenities.create'));

        $response->assertOk();
        $response->assertViewIs('amenity.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AmenityController::class,
            'store',
            \App\Http\Requests\AmenityControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $icon = $this->faker->word();

        $response = $this->post(route('amenities.store'), [
            'name' => $name,
            'icon' => $icon,
        ]);

        $amenities = Amenity::query()
            ->where('name', $name)
            ->where('icon', $icon)
            ->get();
        $this->assertCount(1, $amenities);
        $amenity = $amenities->first();

        $response->assertRedirect(route('amenities.index'));
        $response->assertSessionHas('amenity.id', $amenity->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $amenity = Amenity::factory()->create();

        $response = $this->get(route('amenities.show', $amenity));

        $response->assertOk();
        $response->assertViewIs('amenity.show');
        $response->assertViewHas('amenity');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $amenity = Amenity::factory()->create();

        $response = $this->get(route('amenities.edit', $amenity));

        $response->assertOk();
        $response->assertViewIs('amenity.edit');
        $response->assertViewHas('amenity');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AmenityController::class,
            'update',
            \App\Http\Requests\AmenityControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $amenity = Amenity::factory()->create();
        $name = $this->faker->name();
        $icon = $this->faker->word();

        $response = $this->put(route('amenities.update', $amenity), [
            'name' => $name,
            'icon' => $icon,
        ]);

        $amenity->refresh();

        $response->assertRedirect(route('amenities.index'));
        $response->assertSessionHas('amenity.id', $amenity->id);

        $this->assertEquals($name, $amenity->name);
        $this->assertEquals($icon, $amenity->icon);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $amenity = Amenity::factory()->create();

        $response = $this->delete(route('amenities.destroy', $amenity));

        $response->assertRedirect(route('amenities.index'));

        $this->assertModelMissing($amenity);
    }
}
