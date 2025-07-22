<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Threaddit\Domains\Posting\Enums\ReplyStatus;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('replies', static function (Blueprint $table): void {
            $table->ulid('id')->primary();

            $table->string('status')->default(ReplyStatus::Pending);

            $table->text('body')->comment('The main content of the reply.');

            $table->jsonb('meta')->nullable()->comment('Miscellaneous information for the thread.'); // links, tags, other random stuff

            $table
                ->foreignUlid('thread_id')
                ->index()
                ->constrained('threads')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('replies');
    }
};
