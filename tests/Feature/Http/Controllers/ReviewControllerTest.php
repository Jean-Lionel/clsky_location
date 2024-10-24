<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Property;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReviewController
 */
final class ReviewControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $reviews = Review::factory()->count(3)->create();

        $response = $this->get(route('reviews.index'));

        $response->assertOk();
        $response->assertViewIs('review.index');
        $response->assertViewHas('reviews');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('reviews.create'));

        $response->assertOk();
        $response->assertViewIs('review.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReviewController::class,
            'store',
            \App\Http\Requests\ReviewControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $property = Property::factory()->create();
        $user = User::factory()->create();
        $rating = $this->faker->numberBetween(-10000, 10000);
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('reviews.store'), [
            'property_id' => $property->id,
            'user_id' => $user->id,
            'rating' => $rating,
            'status' => $status,
        ]);

        $reviews = Review::query()
            ->where('property_id', $property->id)
            ->where('user_id', $user->id)
            ->where('rating', $rating)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $reviews);
        $review = $reviews->first();

        $response->assertRedirect(route('reviews.index'));
        $response->assertSessionHas('review.id', $review->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $review = Review::factory()->create();

        $response = $this->get(route('reviews.show', $review));

        $response->assertOk();
        $response->assertViewIs('review.show');
        $response->assertViewHas('review');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $review = Review::factory()->create();

        $response = $this->get(route('reviews.edit', $review));

        $response->assertOk();
        $response->assertViewIs('review.edit');
        $response->assertViewHas('review');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReviewController::class,
            'update',
            \App\Http\Requests\ReviewControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $review = Review::factory()->create();
        $property = Property::factory()->create();
        $user = User::factory()->create();
        $rating = $this->faker->numberBetween(-10000, 10000);
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('reviews.update', $review), [
            'property_id' => $property->id,
            'user_id' => $user->id,
            'rating' => $rating,
            'status' => $status,
        ]);

        $review->refresh();

        $response->assertRedirect(route('reviews.index'));
        $response->assertSessionHas('review.id', $review->id);

        $this->assertEquals($property->id, $review->property_id);
        $this->assertEquals($user->id, $review->user_id);
        $this->assertEquals($rating, $review->rating);
        $this->assertEquals($status, $review->status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $review = Review::factory()->create();

        $response = $this->delete(route('reviews.destroy', $review));

        $response->assertRedirect(route('reviews.index'));

        $this->assertModelMissing($review);
    }
}
