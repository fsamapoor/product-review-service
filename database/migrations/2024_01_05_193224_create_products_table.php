<?php

declare(strict_types=1);

use App\Models\Provider;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Provider::class)->constrained();
            $table->string('name');
            $table->text('description');
            $table->timestamp('set_to_commentable_at')->nullable();
            $table->timestamp('set_to_votable_at')->nullable();
            $table->timestamp('set_to_publicly_reviewable')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }
};
