<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PropertyController
 */
final class PropertyControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $properties = Property::factory()->count(3)->create();

        $response = $this->get(route('properties.index'));

        $response->assertOk();
        $response->assertViewIs('property.index');
        $response->assertViewHas('properties');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('properties.create'));

        $response->assertOk();
        $response->assertViewIs('property.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PropertyController::class,
            'store',
            \App\Http\Requests\PropertyControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug();
        $description = $this->faker->text();
        $address = $this->faker->text();
        $city = $this->faker->city();
        $country = $this->faker->country();
        $postal_code = $this->faker->postcode();
        $price = $this->faker->randomFloat(/** decimal_attributes **/);
        $bedrooms = $this->faker->numberBetween(-10000, 10000);
        $bathrooms = $this->faker->numberBetween(-10000, 10000);
        $area = $this->faker->randomFloat(/** decimal_attributes **/);
        $furnished = $this->faker->boolean();
        $available = $this->faker->boolean();
        $type = $this->faker->randomElement(/** enum_attributes **/);
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $featured = $this->faker->boolean();
        $user = User::factory()->create();

        $response = $this->post(route('properties.store'), [
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'address' => $address,
            'city' => $city,
            'country' => $country,
            'postal_code' => $postal_code,
            'price' => $price,
            'bedrooms' => $bedrooms,
            'bathrooms' => $bathrooms,
            'area' => $area,
            'furnished' => $furnished,
            'available' => $available,
            'type' => $type,
            'status' => $status,
            'featured' => $featured,
            'user_id' => $user->id,
        ]);

        $properties = Property::query()
            ->where('title', $title)
            ->where('slug', $slug)
            ->where('description', $description)
            ->where('address', $address)
            ->where('city', $city)
            ->where('country', $country)
            ->where('postal_code', $postal_code)
            ->where('price', $price)
            ->where('bedrooms', $bedrooms)
            ->where('bathrooms', $bathrooms)
            ->where('area', $area)
            ->where('furnished', $furnished)
            ->where('available', $available)
            ->where('type', $type)
            ->where('status', $status)
            ->where('featured', $featured)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $properties);
        $property = $properties->first();

        $response->assertRedirect(route('properties.index'));
        $response->assertSessionHas('property.id', $property->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $property = Property::factory()->create();

        $response = $this->get(route('properties.show', $property));

        $response->assertOk();
        $response->assertViewIs('property.show');
        $response->assertViewHas('property');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $property = Property::factory()->create();

        $response = $this->get(route('properties.edit', $property));

        $response->assertOk();
        $response->assertViewIs('property.edit');
        $response->assertViewHas('property');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PropertyController::class,
            'update',
            \App\Http\Requests\PropertyControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $property = Property::factory()->create();
        $title = $this->faker->sentence(4);
        $slug = $this->faker->slug();
        $description = $this->faker->text();
        $address = $this->faker->text();
        $city = $this->faker->city();
        $country = $this->faker->country();
        $postal_code = $this->faker->postcode();
        $price = $this->faker->randomFloat(/** decimal_attributes **/);
        $bedrooms = $this->faker->numberBetween(-10000, 10000);
        $bathrooms = $this->faker->numberBetween(-10000, 10000);
        $area = $this->faker->randomFloat(/** decimal_attributes **/);
        $furnished = $this->faker->boolean();
        $available = $this->faker->boolean();
        $type = $this->faker->randomElement(/** enum_attributes **/);
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $featured = $this->faker->boolean();
        $user = User::factory()->create();

        $response = $this->put(route('properties.update', $property), [
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'address' => $address,
            'city' => $city,
            'country' => $country,
            'postal_code' => $postal_code,
            'price' => $price,
            'bedrooms' => $bedrooms,
            'bathrooms' => $bathrooms,
            'area' => $area,
            'furnished' => $furnished,
            'available' => $available,
            'type' => $type,
            'status' => $status,
            'featured' => $featured,
            'user_id' => $user->id,
        ]);

        $property->refresh();

        $response->assertRedirect(route('properties.index'));
        $response->assertSessionHas('property.id', $property->id);

        $this->assertEquals($title, $property->title);
        $this->assertEquals($slug, $property->slug);
        $this->assertEquals($description, $property->description);
        $this->assertEquals($address, $property->address);
        $this->assertEquals($city, $property->city);
        $this->assertEquals($country, $property->country);
        $this->assertEquals($postal_code, $property->postal_code);
        $this->assertEquals($price, $property->price);
        $this->assertEquals($bedrooms, $property->bedrooms);
        $this->assertEquals($bathrooms, $property->bathrooms);
        $this->assertEquals($area, $property->area);
        $this->assertEquals($furnished, $property->furnished);
        $this->assertEquals($available, $property->available);
        $this->assertEquals($type, $property->type);
        $this->assertEquals($status, $property->status);
        $this->assertEquals($featured, $property->featured);
        $this->assertEquals($user->id, $property->user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $property = Property::factory()->create();

        $response = $this->delete(route('properties.destroy', $property));

        $response->assertRedirect(route('properties.index'));

        $this->assertSoftDeleted($property);
    }
}
