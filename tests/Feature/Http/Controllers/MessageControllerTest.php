<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Message;
use App\Models\Receiver;
use App\Models\Sender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MessageController
 */
final class MessageControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $messages = Message::factory()->count(3)->create();

        $response = $this->get(route('messages.index'));

        $response->assertOk();
        $response->assertViewIs('message.index');
        $response->assertViewHas('messages');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('messages.create'));

        $response->assertOk();
        $response->assertViewIs('message.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MessageController::class,
            'store',
            \App\Http\Requests\MessageControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $sender = Sender::factory()->create();
        $receiver = Receiver::factory()->create();
        $content = $this->faker->paragraphs(3, true);

        $response = $this->post(route('messages.store'), [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'content' => $content,
        ]);

        $messages = Message::query()
            ->where('sender_id', $sender->id)
            ->where('receiver_id', $receiver->id)
            ->where('content', $content)
            ->get();
        $this->assertCount(1, $messages);
        $message = $messages->first();

        $response->assertRedirect(route('messages.index'));
        $response->assertSessionHas('message.id', $message->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $message = Message::factory()->create();

        $response = $this->get(route('messages.show', $message));

        $response->assertOk();
        $response->assertViewIs('message.show');
        $response->assertViewHas('message');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $message = Message::factory()->create();

        $response = $this->get(route('messages.edit', $message));

        $response->assertOk();
        $response->assertViewIs('message.edit');
        $response->assertViewHas('message');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MessageController::class,
            'update',
            \App\Http\Requests\MessageControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $message = Message::factory()->create();
        $sender = Sender::factory()->create();
        $receiver = Receiver::factory()->create();
        $content = $this->faker->paragraphs(3, true);

        $response = $this->put(route('messages.update', $message), [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'content' => $content,
        ]);

        $message->refresh();

        $response->assertRedirect(route('messages.index'));
        $response->assertSessionHas('message.id', $message->id);

        $this->assertEquals($sender->id, $message->sender_id);
        $this->assertEquals($receiver->id, $message->receiver_id);
        $this->assertEquals($content, $message->content);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $message = Message::factory()->create();

        $response = $this->delete(route('messages.destroy', $message));

        $response->assertRedirect(route('messages.index'));

        $this->assertModelMissing($message);
    }
}
