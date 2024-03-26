<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notification history') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg divide-y dark:divide-gray-900">
                    <!-- Search form by date -->
                    <form method="POST" action="{{ route('notifications.searchByDate') }}" class="p-6 flex space-x-2">
                        @csrf
                        <label for="start_date">Start Date:</label>
                        <input type="date" name="start_date" id="start_date">

                        <label for="end_date">End Date:</label>
                        <input type="date" name="end_date" id="end_date">

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
                    </form>
                    @foreach($notifications as $notification)
                        <div class="p-6 flex space-x-2">
                            <svg class="h-6 w-6 text-gray-600 dark:text-gray-400 -scale-x-100" data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __($notification->messageCategory->name) }}</h4>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-gray-800 dark:text-gray-200">{{ $notification->user_name }}</span>
                                        <small class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $notification->created_at->format('j M Y, g:i a') }}</small>
                                    </div>
                                    <div>
                                        <span class="text-gray-800 dark:text-gray-200">{{ __($notification->notificationChannel->description) }}</span>
                                    </div>
                                </div>
                                <p class="mt-4 text-lg text-gray-900 dark:text-gray-100">{{ $notification->message }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
