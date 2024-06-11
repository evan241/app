<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notification_channels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });

        // Fill the table with predefined data (catalog)
        $this->populateChannels();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_channels');
    }

    /**
     * Fills the table with predefined data (catalog) of notification channels.
     *
     * @return void
     */
    private function populateChannels()
    {
        // Define notification types
        $types = [
            ['name' => 'sms', 'description' => 'Short Message Service'],
            ['name' => 'mail', 'description' => 'Email'],
            ['name' => 'push', 'description' => 'Push notification']
        ];

        // Insert data into table
        foreach ($types as $type) {
            \App\Models\NotificationChannel::create($type);
        }
    }
};
