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
        Schema::create('message_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });

        // Fill the table with predefined data (catalog)
        $this->populateCategories();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_categories');
    }

    /**
     * Fills the table with predefined data (catalog) of message categories.
     *
     * @return void
     */
    private function populateCategories()
    {
        // Define message categories
        $categories = [
            ['name' => 'Sports', 'description' => 'Sports related news'],
            ['name' => 'Finance', 'description' => 'Information on financial topics'],
            ['name' => 'Movies', 'description' => 'Movie news and reviews']
        ];

        // Insert the data into the table
        foreach ($categories as $category) {
            \App\Models\MessageCategory::create($category);
        }
    }
};
