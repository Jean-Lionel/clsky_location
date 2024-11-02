<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Depense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DepenseController
 */
final class DepenseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $depenses = Depense::factory()->count(3)->create();

        $response = $this->get(route('depenses.index'));

        $response->assertOk();
        $response->assertViewIs('depense.index');
        $response->assertViewHas('depenses');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('depenses.create'));

        $response->assertOk();
        $response->assertViewIs('depense.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DepenseController::class,
            'store',
            \App\Http\Requests\DepenseStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('depenses.store'));

        $response->assertRedirect(route('depenses.index'));
        $response->assertSessionHas('depense.id', $depense->id);

        $this->assertDatabaseHas(depenses, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $depense = Depense::factory()->create();

        $response = $this->get(route('depenses.show', $depense));

        $response->assertOk();
        $response->assertViewIs('depense.show');
        $response->assertViewHas('depense');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $depense = Depense::factory()->create();

        $response = $this->get(route('depenses.edit', $depense));

        $response->assertOk();
        $response->assertViewIs('depense.edit');
        $response->assertViewHas('depense');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DepenseController::class,
            'update',
            \App\Http\Requests\DepenseUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $depense = Depense::factory()->create();

        $response = $this->put(route('depenses.update', $depense));

        $depense->refresh();

        $response->assertRedirect(route('depenses.index'));
        $response->assertSessionHas('depense.id', $depense->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $depense = Depense::factory()->create();

        $response = $this->delete(route('depenses.destroy', $depense));

        $response->assertRedirect(route('depenses.index'));

        $this->assertModelMissing($depense);
    }
}
