<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
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
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('post_type_id');
            $table->unsignedInteger('lowest_price')->default(0);
            $table->unsignedInteger('highest_price')->default(500000);
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('district_id');
            $table->unsignedInteger('street_id');
            $table->string('title', 50);
            $table->text('image')->nullable();
            $table->text('content');
            $table->text('address');
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
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
}
