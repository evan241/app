<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;

use App\Models\Notification;
use App\Repositories\MessageCategoryRepository;

class NotificationControllerTest extends TestCase
{
    /** @test */
    public function index()
    {
        // Post Category Repository Mock
        $messageCategoryRepositoryMock = Mockery::mock(MessageCategoryRepository::class);
        
       // We simulate that getAllCategories returns an empty array to simplify the test
        $messageCategoryRepositoryMock->shouldReceive('getAllCategories')->andReturn([]);
        
        // Bind mock repository in controller
        $this->app->instance(MessageCategoryRepository::class, $messageCategoryRepositoryMock);

        // Make a GET request to the controller route
        $response = $this->get(route('notifications.index'));

        // Verify that the response has a status code of 200
        $response->assertStatus(200);
        
        // Verify that the returned view is 'notifications.index'
        $response->assertViewIs('notifications.index');
        
        // Verify that the 'messageCategories' variable is present in the view
        $response->assertViewHas('messageCategories');
    }

    /** @test */
    public function store()
    {
        // Simulate sending a notification and then verify if it has been stored correctly in the database
        $response = $this->post(route('notifications.store'), [
            'message' => 'Mensaje de prueba',
            'message_category_id' => 1,
        ]);

        $response->assertStatus(302); // Check the redirect after sending the notification
        $this->assertDatabaseHas('notifications', ['message' => 'Mensaje de prueba']);
    }

    /** @test */
    public function show_history()
    {
        $response = $this->get(route('notifications.history'));

        $response->assertStatus(200);
        $response->assertViewIs('notifications.history');
    }

    /** @test */
    public function it_can_search_notifications_by_creation_date()
    {
        $notification = Notification::factory()->create(['created_at' => now()]);

        $response = $this->get(route('notifications.history', [
            'field' => 'created_at', 
            'start_date' => now()->format('Y-m-d H:i:s'), 
            'end_date' => now()->format('Y-m-d H:i:s')
        ]));

        $response->assertStatus(200)
            ->assertViewIs('notifications.history')
            ->assertViewHas('notifications');
    }

    /** @test */
    public function it_can_search_notifications_by_user_name()
    {
        $notification = Notification::factory()->create(['user_name' => 'John Doe']);

        $response = $this->get(route('notifications.history', ['field' => 'user_name', 'search_for' => 'John Doe']));

        $response->assertStatus(200)
            ->assertViewIs('notifications.history')
            ->assertViewHas('notifications');
    }

    /** @test */
    public function it_can_search_notifications_by_user_email()
    {
        $notification = Notification::factory()->create(['user_email' => 'john@example.com']);

        $response = $this->get(route('notifications.history', ['field' => 'user_email', 'search_for' => 'john@example.com']));

        $response->assertStatus(200)
            ->assertViewIs('notifications.history')
            ->assertViewHas('notifications');
    }

    /** @test */
    public function it_can_search_notifications_by_user_phone()
    {
        $notification = Notification::factory()->create(['user_phone' => '123456789']);

        $response = $this->get(route('notifications.history', ['field' => 'user_phone', 'search_for' => '123456789']));

        $response->assertStatus(200)
            ->assertViewIs('notifications.history')
            ->assertViewHas('notifications');
    }

    /** @test */
    public function it_can_search_notifications_by_category()
    {
        $notification = Notification::factory()->create(['message_category_id' => 1]);

        $response = $this->get(route('notifications.history', ['field' => 'message_category_id', 'message_category_id' => 1]));

        $response->assertStatus(200)
            ->assertViewIs('notifications.history')
            ->assertViewHas('notifications');
    }

    /** @test */
    public function it_can_search_notifications_by_channel()
    {
        $notification = Notification::factory()->create(['notification_channel_id' => 1]);

        $response = $this->get(route('notifications.history', ['field' => 'notification_channel_id', 'notification_channel_id' => 1]));

        $response->assertStatus(200)
            ->assertViewIs('notifications.history')
            ->assertViewHas('notifications');
    }

    /** @test */
    public function it_can_search_notifications_by_status()
    {
        $notification = Notification::factory()->create(['send_status' => 'pending']);

        $response = $this->get(route('notifications.history', ['field' => 'send_status', 'search_for' => 'pending']));

        $response->assertStatus(200)
            ->assertViewIs('notifications.history')
            ->assertViewHas('notifications');
    }
}
