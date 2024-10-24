<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\NotificationController
 */
final class NotificationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $notifications = Notification::factory()->count(3)->create();

        $response = $this->get(route('notifications.index'));

        $response->assertOk();
        $response->assertViewIs('notification.index');
        $response->assertViewHas('notifications');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('notifications.create'));

        $response->assertOk();
        $response->assertViewIs('notification.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NotificationController::class,
            'store',
            \App\Http\Requests\NotificationControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();
        $title = $this->faker->sentence(4);
        $content = $this->faker->paragraphs(3, true);
        $type = $this->faker->word();

        $response = $this->post(route('notifications.store'), [
            'user_id' => $user->id,
            'title' => $title,
            'content' => $content,
            'type' => $type,
        ]);

        $notifications = Notification::query()
            ->where('user_id', $user->id)
            ->where('title', $title)
            ->where('content', $content)
            ->where('type', $type)
            ->get();
        $this->assertCount(1, $notifications);
        $notification = $notifications->first();

        $response->assertRedirect(route('notifications.index'));
        $response->assertSessionHas('notification.id', $notification->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $notification = Notification::factory()->create();

        $response = $this->get(route('notifications.show', $notification));

        $response->assertOk();
        $response->assertViewIs('notification.show');
        $response->assertViewHas('notification');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $notification = Notification::factory()->create();

        $response = $this->get(route('notifications.edit', $notification));

        $response->assertOk();
        $response->assertViewIs('notification.edit');
        $response->assertViewHas('notification');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NotificationController::class,
            'update',
            \App\Http\Requests\NotificationControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $notification = Notification::factory()->create();
        $user = User::factory()->create();
        $title = $this->faker->sentence(4);
        $content = $this->faker->paragraphs(3, true);
        $type = $this->faker->word();

        $response = $this->put(route('notifications.update', $notification), [
            'user_id' => $user->id,
            'title' => $title,
            'content' => $content,
            'type' => $type,
        ]);

        $notification->refresh();

        $response->assertRedirect(route('notifications.index'));
        $response->assertSessionHas('notification.id', $notification->id);

        $this->assertEquals($user->id, $notification->user_id);
        $this->assertEquals($title, $notification->title);
        $this->assertEquals($content, $notification->content);
        $this->assertEquals($type, $notification->type);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $notification = Notification::factory()->create();

        $response = $this->delete(route('notifications.destroy', $notification));

        $response->assertRedirect(route('notifications.index'));

        $this->assertModelMissing($notification);
    }
}
