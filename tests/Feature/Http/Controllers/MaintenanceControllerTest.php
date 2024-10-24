<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Property;
use App\Models\ReportedBy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MaintenanceController
 */
final class MaintenanceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $maintenances = Maintenance::factory()->count(3)->create();

        $response = $this->get(route('maintenances.index'));

        $response->assertOk();
        $response->assertViewIs('maintenance.index');
        $response->assertViewHas('maintenances');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('maintenances.create'));

        $response->assertOk();
        $response->assertViewIs('maintenance.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MaintenanceController::class,
            'store',
            \App\Http\Requests\MaintenanceControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $property = Property::factory()->create();
        $reported_by = ReportedBy::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();
        $priority = $this->faker->randomElement(/** enum_attributes **/);
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('maintenances.store'), [
            'property_id' => $property->id,
            'reported_by' => $reported_by->id,
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
            'status' => $status,
        ]);

        $maintenances = Maintenance::query()
            ->where('property_id', $property->id)
            ->where('reported_by', $reported_by->id)
            ->where('title', $title)
            ->where('description', $description)
            ->where('priority', $priority)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $maintenances);
        $maintenance = $maintenances->first();

        $response->assertRedirect(route('maintenances.index'));
        $response->assertSessionHas('maintenance.id', $maintenance->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $maintenance = Maintenance::factory()->create();

        $response = $this->get(route('maintenances.show', $maintenance));

        $response->assertOk();
        $response->assertViewIs('maintenance.show');
        $response->assertViewHas('maintenance');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $maintenance = Maintenance::factory()->create();

        $response = $this->get(route('maintenances.edit', $maintenance));

        $response->assertOk();
        $response->assertViewIs('maintenance.edit');
        $response->assertViewHas('maintenance');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MaintenanceController::class,
            'update',
            \App\Http\Requests\MaintenanceControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $maintenance = Maintenance::factory()->create();
        $property = Property::factory()->create();
        $reported_by = ReportedBy::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();
        $priority = $this->faker->randomElement(/** enum_attributes **/);
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('maintenances.update', $maintenance), [
            'property_id' => $property->id,
            'reported_by' => $reported_by->id,
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
            'status' => $status,
        ]);

        $maintenance->refresh();

        $response->assertRedirect(route('maintenances.index'));
        $response->assertSessionHas('maintenance.id', $maintenance->id);

        $this->assertEquals($property->id, $maintenance->property_id);
        $this->assertEquals($reported_by->id, $maintenance->reported_by);
        $this->assertEquals($title, $maintenance->title);
        $this->assertEquals($description, $maintenance->description);
        $this->assertEquals($priority, $maintenance->priority);
        $this->assertEquals($status, $maintenance->status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $maintenance = Maintenance::factory()->create();

        $response = $this->delete(route('maintenances.destroy', $maintenance));

        $response->assertRedirect(route('maintenances.index'));

        $this->assertModelMissing($maintenance);
    }
}
