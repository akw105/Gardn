<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

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
            $table->id();
            $table->string('uuid')->unique();
            $table->foreignIdFor(User::class);
            $table->foreignId('blog_id')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body')->nullable();
            $table->text('teaser')->nullable();
            $table->boolean('published')->default(true);
            $table->boolean('public')->default(true);
            $table->string('source')->nullable();
            $table->string('external_url')->nullable();
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
