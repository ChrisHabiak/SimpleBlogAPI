<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // MySQL 8 supports descending indexes
        DB::statement('ALTER TABLE `posts` ADD INDEX `posts_id_desc_index` (`id` DESC)');
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
