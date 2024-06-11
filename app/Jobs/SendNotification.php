<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\NotificationStrategies\NotificationStrategy;
use App\Notifications\NotificationFactory;
use App\Notifications\NotificationContext;
use Illuminate\Support\Facades\Log;
use Exception;


class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Set the number of retries
    public $tries = 3;

    protected $message;
    protected $user;
    protected $categoryId;
    protected $categoryName;
    protected $channelId;
    protected $channelName;

    /**
     * Create a new job instance.
     */
    public function __construct($message, $user, $categoryId, $categoryName, $channelId, $channelName)
    {
        $this->message = $message;
        $this->user = $user;
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
        $this->channelId = $channelId;
        $this->channelName = $channelName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Instantiate the appropriate notification strategy using the factory
            $notificationStrategy = NotificationFactory::createNotificationStrategy($this->channelName);

            // Create an instance of the notification context and pass the strategy as an argument in the constructor
            $notificationContext = new NotificationContext($notificationStrategy);
            
            // Send the notification and capture the status of the attempt
            $notificationContext->sendNotification($this->message, $this->user, $this->categoryId, $this->categoryName, $this->channelId, $this->channelName);

        } catch (\Exception $e) {
            Log::error('Error processing job: ' . $e->getMessage(), [
                'message' => $this->message,
                'user_id' => $this->user->id,
                'category_id' => $this->categoryId,
                'channel_id' => $this->channelId,
            ]);
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Number of retrieds exceeded
        Log::error('Job failed: ' . $exception->getMessage());
    }
}
