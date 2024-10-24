<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReservationController
 */
final class ReservationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $reservations = Reservation::factory()->count(3)->create();

        $response = $this->get(route('reservations.index'));

        $response->assertOk();
        $response->assertViewIs('reservation.index');
        $response->assertViewHas('reservations');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('reservations.create'));

        $response->assertOk();
        $response->assertViewIs('reservation.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReservationController::class,
            'store',
            \App\Http\Requests\ReservationControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $property = Property::factory()->create();
        $user = User::factory()->create();
        $check_in = Carbon::parse($this->faker->date());
        $check_out = Carbon::parse($this->faker->date());
        $total_price = $this->faker->randomFloat(/** decimal_attributes **/);
        $guests = $this->faker->numberBetween(-10000, 10000);
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $payment_status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('reservations.store'), [
            'property_id' => $property->id,
            'user_id' => $user->id,
            'check_in' => $check_in->toDateString(),
            'check_out' => $check_out->toDateString(),
            'total_price' => $total_price,
            'guests' => $guests,
            'status' => $status,
            'payment_status' => $payment_status,
        ]);

        $reservations = Reservation::query()
            ->where('property_id', $property->id)
            ->where('user_id', $user->id)
            ->where('check_in', $check_in)
            ->where('check_out', $check_out)
            ->where('total_price', $total_price)
            ->where('guests', $guests)
            ->where('status', $status)
            ->where('payment_status', $payment_status)
            ->get();
        $this->assertCount(1, $reservations);
        $reservation = $reservations->first();

        $response->assertRedirect(route('reservations.index'));
        $response->assertSessionHas('reservation.id', $reservation->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->get(route('reservations.show', $reservation));

        $response->assertOk();
        $response->assertViewIs('reservation.show');
        $response->assertViewHas('reservation');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->get(route('reservations.edit', $reservation));

        $response->assertOk();
        $response->assertViewIs('reservation.edit');
        $response->assertViewHas('reservation');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReservationController::class,
            'update',
            \App\Http\Requests\ReservationControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $reservation = Reservation::factory()->create();
        $property = Property::factory()->create();
        $user = User::factory()->create();
        $check_in = Carbon::parse($this->faker->date());
        $check_out = Carbon::parse($this->faker->date());
        $total_price = $this->faker->randomFloat(/** decimal_attributes **/);
        $guests = $this->faker->numberBetween(-10000, 10000);
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $payment_status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('reservations.update', $reservation), [
            'property_id' => $property->id,
            'user_id' => $user->id,
            'check_in' => $check_in->toDateString(),
            'check_out' => $check_out->toDateString(),
            'total_price' => $total_price,
            'guests' => $guests,
            'status' => $status,
            'payment_status' => $payment_status,
        ]);

        $reservation->refresh();

        $response->assertRedirect(route('reservations.index'));
        $response->assertSessionHas('reservation.id', $reservation->id);

        $this->assertEquals($property->id, $reservation->property_id);
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($check_in, $reservation->check_in);
        $this->assertEquals($check_out, $reservation->check_out);
        $this->assertEquals($total_price, $reservation->total_price);
        $this->assertEquals($guests, $reservation->guests);
        $this->assertEquals($status, $reservation->status);
        $this->assertEquals($payment_status, $reservation->payment_status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->delete(route('reservations.destroy', $reservation));

        $response->assertRedirect(route('reservations.index'));

        $this->assertModelMissing($reservation);
    }
}
