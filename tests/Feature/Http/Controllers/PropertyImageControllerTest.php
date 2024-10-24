<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PropertyImageController
 */
final class PropertyImageControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $propertyImages = PropertyImage::factory()->count(3)->create();

        $response = $this->get(route('property-images.index'));

        $response->assertOk();
        $response->assertViewIs('propertyImage.index');
        $response->assertViewHas('propertyImages');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('property-images.create'));

        $response->assertOk();
        $response->assertViewIs('propertyImage.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PropertyImageController::class,
            'store',
            \App\Http\Requests\PropertyImageControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $property = Property::factory()->create();
        $image_path = $this->faker->word();
        $is_primary = $this->faker->boolean();
        $sort_order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('property-images.store'), [
            'property_id' => $property->id,
            'image_path' => $image_path,
            'is_primary' => $is_primary,
            'sort_order' => $sort_order,
        ]);

        $propertyImages = PropertyImage::query()
            ->where('property_id', $property->id)
            ->where('image_path', $image_path)
            ->where('is_primary', $is_primary)
            ->where('sort_order', $sort_order)
            ->get();
        $this->assertCount(1, $propertyImages);
        $propertyImage = $propertyImages->first();

        $response->assertRedirect(route('propertyImages.index'));
        $response->assertSessionHas('propertyImage.id', $propertyImage->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $propertyImage = PropertyImage::factory()->create();

        $response = $this->get(route('property-images.show', $propertyImage));

        $response->assertOk();
        $response->assertViewIs('propertyImage.show');
        $response->assertViewHas('propertyImage');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $propertyImage = PropertyImage::factory()->create();

        $response = $this->get(route('property-images.edit', $propertyImage));

        $response->assertOk();
        $response->assertViewIs('propertyImage.edit');
        $response->assertViewHas('propertyImage');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PropertyImageController::class,
            'update',
            \App\Http\Requests\PropertyImageControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $propertyImage = PropertyImage::factory()->create();
        $property = Property::factory()->create();
        $image_path = $this->faker->word();
        $is_primary = $this->faker->boolean();
        $sort_order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('property-images.update', $propertyImage), [
            'property_id' => $property->id,
            'image_path' => $image_path,
            'is_primary' => $is_primary,
            'sort_order' => $sort_order,
        ]);

        $propertyImage->refresh();

        $response->assertRedirect(route('propertyImages.index'));
        $response->assertSessionHas('propertyImage.id', $propertyImage->id);

        $this->assertEquals($property->id, $propertyImage->property_id);
        $this->assertEquals($image_path, $propertyImage->image_path);
        $this->assertEquals($is_primary, $propertyImage->is_primary);
        $this->assertEquals($sort_order, $propertyImage->sort_order);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $propertyImage = PropertyImage::factory()->create();

        $response = $this->delete(route('property-images.destroy', $propertyImage));

        $response->assertRedirect(route('propertyImages.index'));

        $this->assertModelMissing($propertyImage);
    }
}
