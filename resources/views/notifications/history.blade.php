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
                    <form class="form-inline mb-4">
                        @csrf
                        <div class="flex items-center space-x-4">
                            <div class="flex-none">
                                <select name="field" class="form-control mr-sm-2">
                                    <option value="0" {{ $oldField == 0 ? 'selected' : '' }}>{{ __('Search by') }}</option>
                                    <option value="created_at" {{ $oldField == 'created_at' ? 'selected' : '' }}>{{ __('Date') }}</option>
                                    <option value="user_name" {{ $oldField == 'user_name' ? 'selected' : '' }}>{{ __('Name') }}</option>
                                    <option value="user_email" {{ $oldField == 'user_email' ? 'selected' : '' }}>{{ __('Email') }}</option>
                                    <option value="user_phone" {{ $oldField == 'user_phone' ? 'selected' : '' }}>{{ __('Phone') }}</option>
                                    <option value="message_category_id" {{ $oldField == 'message_category_id' ? 'selected' : '' }}>{{ __('Category') }}</option>
                                    <option value="notification_channel_id" {{ $oldField == 'notification_channel_id' ? 'selected' : '' }}>{{ __('Channel') }}</option>
                                    <option value="send_status" {{ $oldField == 'send_status' ? 'selected' : '' }}>{{ __('Status') }}</option>
                                </select>
                            </div>
                            @php
                                $displaySearchFor = in_array($oldField, ['user_name', 'user_email', 'user_phone', 'send_status']) ? 'block' : 'none';
                                $displayDatesFields = $oldField == 'created_at'?"block":"none";
                                $displayCategoryFields = $oldField == 'message_category_id'?"block":"none";
                                $displayChannelFields = $oldField == 'notification_channel_id'?"block":"none";
                            @endphp
                            <div class="form-group search-for" style="display: {{ $displaySearchFor }};">
                                <input name="search_for" class="form-control mr-sm-2" type="search" placeholder="{{ __('Field') }}" aria-label="Search" value="{{ $oldSearchFor?$oldSearchFor:"" }}">
                            </div>
                            <div class="form-group date-fields" style="display: {{ $displayDatesFields }};">
                                <input name="start_date" class="form-control mr-sm-2" type="date" placeholder="{{ __('Start Date') }}" aria-label="Start Date" value="{{ $oldStartDate?$oldStartDate:now()->format('Y-m-d') }}">
                                <input name="end_date" class="form-control mr-sm-2" type="date" placeholder="{{ __('End Date') }}" aria-label="End Date" value="{{ $oldEndDate?$oldEndDate:now()->format('Y-m-d') }}">
                            </div>
                            <div class="form-group category-fields" style="display: {{ $displayCategoryFields }};">
                                <select name="message_category_id"
                                    class="block w-full rounded-md border-gray-300 bg-white shadow-sm transition-colors duration-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-indigo-300 dark:focus:ring dark:focus:ring-indigo-200 dark:focus:ring-opacity-50">
                                    <option value="">{{ __('Select a category') }}</option>
                                    @foreach($messageCategories as $category)
                                        <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group channel-fields" style="display: {{ $displayChannelFields }};">
                                <select name="notification_channel_id"
                                    class="block w-full rounded-md border-gray-300 bg-white shadow-sm transition-colors duration-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-indigo-300 dark:focus:ring dark:focus:ring-indigo-200 dark:focus:ring-opacity-50">
                                    <option value="">{{ __('Select a channel') }}</option>
                                    @foreach($notificationChannels as $channel)
                                        <option value="{{ $channel->id }}">{{ __($channel->description) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-none">
                                <x-primary-button class="my-2 my-sm-0" type="submit">{{ __('Search') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                    @if ($notifications->isEmpty())
                        <div class="p-6">
                            <p>{{ __('No results found.') }}</p>
                        </div>
                    @else
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
                                        <div>
                                            <span class="text-gray-800 dark:text-gray-200">{{ __($notification->notificationChannel->description) }}<br>{{ __('Phone') }}: {{ $notification->user_phone }}<br>{{ __('Email') }}: {{ $notification->user_email }}</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-gray-800 dark:text-gray-200">{{ $notification->user_name }}</span>
                                            <small class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $notification->created_at->format('j M Y, g:i a') }}</small>
                                        </div>
                                    </div>
                                    <p class="mt-4 text-lg text-gray-900 dark:text-gray-100">{{ $notification->message }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectField = document.querySelector('select[name="field"]');
        const dateFields = document.querySelector('.date-fields');
        const searchForFields = document.querySelector('.search-for');
        const categoryFields = document.querySelector('.category-fields');
        const channelFields = document.querySelector('.channel-fields');

        // Mostrar u ocultar los campos según la opción seleccionada
        selectField.addEventListener('change', function() {
            const selectedOption = this.value;
            if (selectedOption === 'created_at') {
                dateFields.style.display = 'block';
                searchForFields.style.display = 'none';
                categoryFields.style.display = 'none';
                channelFields.style.display = 'none';
            } else if (selectedOption === 'message_category_id') {
                dateFields.style.display = 'none';
                searchForFields.style.display = 'none';
                categoryFields.style.display = 'block';
                channelFields.style.display = 'none';
            } else if (selectedOption === 'notification_channel_id') {
                dateFields.style.display = 'none';
                searchForFields.style.display = 'none';
                categoryFields.style.display = 'none';
                channelFields.style.display = 'block';
            } else if (selectedOption === 'user_name' || selectedOption === 'user_email' || selectedOption === 'user_phone' || selectedOption === 'send_status') {
                dateFields.style.display = 'none';
                searchForFields.style.display = 'block';
                categoryFields.style.display = 'none';
                channelFields.style.display = 'none';
            } else{
                dateFields.style.display = 'none';
                searchForFields.style.display = 'none';
                categoryFields.style.display = 'none';
                channelFields.style.display = 'none';
            }
        });
    });
</script>