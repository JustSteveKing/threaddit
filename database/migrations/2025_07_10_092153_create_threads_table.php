<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('threads', static function (Blueprint $table): void {
            $table->ulid('id')->primary();

            $table->text('body')->comment('The main content of the thread.');

            $table->jsonb('meta')->nullable()->comment('Miscellaneous information for the thread.'); // links, tags, other random stuff

            $table->unsignedBigInteger('reactions')->default(0)->comment('How many reactions this thread has received.');
            $table->unsignedBigInteger('views')->default(0)->comment('How many times this thread has been viewed.');

            $table
                ->foreignUlid('user_id')
                ->index()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('threads');
    }
};
