<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PaymentController
 */
final class PaymentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $payments = Payment::factory()->count(3)->create();

        $response = $this->get(route('payments.index'));

        $response->assertOk();
        $response->assertViewIs('payment.index');
        $response->assertViewHas('payments');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('payments.create'));

        $response->assertOk();
        $response->assertViewIs('payment.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentController::class,
            'store',
            \App\Http\Requests\PaymentControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $reservation = Reservation::factory()->create();
        $user = User::factory()->create();
        $amount = $this->faker->randomFloat(/** decimal_attributes **/);
        $payment_method = $this->faker->randomElement(/** enum_attributes **/);
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('payments.store'), [
            'reservation_id' => $reservation->id,
            'user_id' => $user->id,
            'amount' => $amount,
            'payment_method' => $payment_method,
            'status' => $status,
        ]);

        $payments = Payment::query()
            ->where('reservation_id', $reservation->id)
            ->where('user_id', $user->id)
            ->where('amount', $amount)
            ->where('payment_method', $payment_method)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $payments);
        $payment = $payments->first();

        $response->assertRedirect(route('payments.index'));
        $response->assertSessionHas('payment.id', $payment->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $payment = Payment::factory()->create();

        $response = $this->get(route('payments.show', $payment));

        $response->assertOk();
        $response->assertViewIs('payment.show');
        $response->assertViewHas('payment');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $payment = Payment::factory()->create();

        $response = $this->get(route('payments.edit', $payment));

        $response->assertOk();
        $response->assertViewIs('payment.edit');
        $response->assertViewHas('payment');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentController::class,
            'update',
            \App\Http\Requests\PaymentControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $payment = Payment::factory()->create();
        $reservation = Reservation::factory()->create();
        $user = User::factory()->create();
        $amount = $this->faker->randomFloat(/** decimal_attributes **/);
        $payment_method = $this->faker->randomElement(/** enum_attributes **/);
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('payments.update', $payment), [
            'reservation_id' => $reservation->id,
            'user_id' => $user->id,
            'amount' => $amount,
            'payment_method' => $payment_method,
            'status' => $status,
        ]);

        $payment->refresh();

        $response->assertRedirect(route('payments.index'));
        $response->assertSessionHas('payment.id', $payment->id);

        $this->assertEquals($reservation->id, $payment->reservation_id);
        $this->assertEquals($user->id, $payment->user_id);
        $this->assertEquals($amount, $payment->amount);
        $this->assertEquals($payment_method, $payment->payment_method);
        $this->assertEquals($status, $payment->status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $payment = Payment::factory()->create();

        $response = $this->delete(route('payments.destroy', $payment));

        $response->assertRedirect(route('payments.index'));

        $this->assertModelMissing($payment);
    }
}
