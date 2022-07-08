<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('short_desc');
            $table->text('content');
            $table->text('images');
            $table->unsignedInteger('view_count')->default(0);
            $table->string('video_url')->nullable();
            $table->string('post_type', 10)->default('post')->comment('post / page');
            $table->string('post_format', 15)->default('default')->comment('default / game / video / charactor');
            $table->string('slug_url');
            $table->string('package_id')->nullable();
            $table->unsignedTinyInteger('is_activate')->default(1);
            $table->unsignedInteger('user_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
