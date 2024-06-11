<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotification;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Repositories\MessageCategoryRepository;
use App\Repositories\NotificationChannelRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

class NotificationController extends Controller
{
    protected $notificationRepository;
    protected $userRepository;
    protected $messageCategoryRepository;
    protected $notificationChannelRepository;

    public function __construct(NotificationRepository $notificationRepository, UserRepository $userRepository, MessageCategoryRepository $messageCategoryRepository, NotificationChannelRepository $notificationChannelRepository)
    {
        $this->notificationRepository = $notificationRepository;
        $this->userRepository = $userRepository;
        $this->messageCategoryRepository = $messageCategoryRepository;
        $this->notificationChannelRepository = $notificationChannelRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $messageCategories = $this->messageCategoryRepository->getAllCategories();
        } catch (\Exception $e) {
            // Error handling
            Log::error('Error al obtener las categorías de mensajes: ' . $e->getMessage());
            // Set $messageCategories to a default or empty value on error
            $messageCategories = [];
        }

        return view('notifications.index', compact('messageCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:255'],
            'message_category_id' => ['required', 'exists:message_categories,id'],
        ], [
            'message_category_id.required' => __('The message category field is required.'),
            'message.max' => __('The message cannot be more than :max characters.'),
            'message_category_id.required' => __('The message category is required.'),
            'message_category_id.exists' => __('The selected message category is not valid.'),
        ]);

        $message = $request->get('message');
        $categoryId = $request->get('message_category_id');
        $categoryName = $this->messageCategoryRepository->getCategoryNameById($categoryId);

        // Get users subscribed to message category
        $users = $this->userRepository->getUsersSubscribedToCategory($categoryId);

        // Iterate over each user and send the notification
        $users->each(function ($user) use ($message, $categoryId, $categoryName) {
            // Iterate over the channels and send the notification using the notification factory
            foreach ($user->notificationChannels as $userNotificationChannel) {
                $channelName = $userNotificationChannel->channel->name;
                $channelId = $userNotificationChannel->channel->id;

                // Submit the send notification task to the queue
                SendNotification::dispatch($message, $user, $categoryId, $categoryName, $channelId, $channelName)->onQueue('notifications');
            }
        });

        // Returns an appropriate response based on the result of the submission
        return to_route('notifications.index')->with('status', 'Notification sent');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    public function showHistory(Request $request){

        $notifications = $this->notificationRepository->getSearchNotificationsWithRelations(
            $request->get('field'),
            $request->get('search_for'),
            $request->get('start_date'),
            $request->get('end_date'),
            $request->get('message_category_id'),
            $request->get('notification_channel_id')
        );

        return view('notifications.history', [
            'notifications' => $notifications,
            'messageCategories' => $this->messageCategoryRepository->getAllCategories(),
            'notificationChannels' => $this->notificationChannelRepository->getAllChannels(),
            'oldField' => $request->get('field'),
            'oldSearchFor' => $request->get('search_for'),
            'oldStartDate' => $request->get('start_date'),
            'oldEndDate' => $request->get('end_date'),
            'oldMessageCategoryId' => $request->get('message_category_id'),
            'oldNotificationChannelId' => $request->get('notification_channel_id')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
