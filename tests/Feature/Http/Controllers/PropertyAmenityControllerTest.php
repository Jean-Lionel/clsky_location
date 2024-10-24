<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Amenity;
use App\Models\Property;
use App\Models\PropertyAmenity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PropertyAmenityController
 */
final class PropertyAmenityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $propertyAmenities = PropertyAmenity::factory()->count(3)->create();

        $response = $this->get(route('property-amenities.index'));

        $response->assertOk();
        $response->assertViewIs('propertyAmenity.index');
        $response->assertViewHas('propertyAmenities');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('property-amenities.create'));

        $response->assertOk();
        $response->assertViewIs('propertyAmenity.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PropertyAmenityController::class,
            'store',
            \App\Http\Requests\PropertyAmenityControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $property = Property::factory()->create();
        $amenity = Amenity::factory()->create();

        $response = $this->post(route('property-amenities.store'), [
            'property_id' => $property->id,
            'amenity_id' => $amenity->id,
        ]);

        $propertyAmenities = PropertyAmenity::query()
            ->where('property_id', $property->id)
            ->where('amenity_id', $amenity->id)
            ->get();
        $this->assertCount(1, $propertyAmenities);
        $propertyAmenity = $propertyAmenities->first();

        $response->assertRedirect(route('propertyAmenities.index'));
        $response->assertSessionHas('propertyAmenity.id', $propertyAmenity->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $propertyAmenity = PropertyAmenity::factory()->create();

        $response = $this->get(route('property-amenities.show', $propertyAmenity));

        $response->assertOk();
        $response->assertViewIs('propertyAmenity.show');
        $response->assertViewHas('propertyAmenity');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $propertyAmenity = PropertyAmenity::factory()->create();

        $response = $this->get(route('property-amenities.edit', $propertyAmenity));

        $response->assertOk();
        $response->assertViewIs('propertyAmenity.edit');
        $response->assertViewHas('propertyAmenity');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PropertyAmenityController::class,
            'update',
            \App\Http\Requests\PropertyAmenityControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $propertyAmenity = PropertyAmenity::factory()->create();
        $property = Property::factory()->create();
        $amenity = Amenity::factory()->create();

        $response = $this->put(route('property-amenities.update', $propertyAmenity), [
            'property_id' => $property->id,
            'amenity_id' => $amenity->id,
        ]);

        $propertyAmenity->refresh();

        $response->assertRedirect(route('propertyAmenities.index'));
        $response->assertSessionHas('propertyAmenity.id', $propertyAmenity->id);

        $this->assertEquals($property->id, $propertyAmenity->property_id);
        $this->assertEquals($amenity->id, $propertyAmenity->amenity_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $propertyAmenity = PropertyAmenity::factory()->create();

        $response = $this->delete(route('property-amenities.destroy', $propertyAmenity));

        $response->assertRedirect(route('propertyAmenities.index'));

        $this->assertModelMissing($propertyAmenity);
    }
}
