<?php

declare(strict_types=1);

use App\Http\Controllers;
use App\Jobs\Threads\ReplyToThread;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\actingAs;

use Threaddit\Domains\Posting\Aggregates\ThreadAggregate;
use Threaddit\Domains\Posting\DataObjects\NewReply;
use Threaddit\Domains\Posting\Events\ThreadWasReplied;

describe('creating and managing threads', function (): void {
    test('as an authenticated user I can view all threads', function (): void {
        actingAs(User::factory()->create())->getJson(
            uri: action(Controllers\Threads\IndexController::class),
        )->assertOk();
    });
    test('the threads index payload contains the expected data', function (): void {
        Thread::factory()->count(10)->create();

        actingAs(User::factory()->create())->getJson(
            uri: action(Controllers\Threads\IndexController::class),
        )->assertOk()->assertJson(
            fn(AssertableJson $json) => $json
                ->count(10)
                ->each(
                    fn(AssertableJson $json) => $json
                        ->has('id')
                        ->has('content.body')
                        ->has('content.meta')
                        ->has('content.reactions')
                        ->has('content.views')
                        ->has('created.human')
                        ->has('created.string')
                        ->etc(),
                )->etc(),
        );
    });
    test('the threads index can include the threads user', function (): void {
        Thread::factory()->count(10)->create();
        actingAs(User::factory()->create())->getJson(
            uri: action(Controllers\Threads\IndexController::class, ['include' => 'user']),
        )->assertOk()->assertJson(
            fn(AssertableJson $json) => $json
                ->each(
                    fn(AssertableJson $json) => $json
                        ->has('id')
                        ->has('content.body')
                        ->has('content.meta')
                        ->has('content.reactions')
                        ->has('content.views')
                        ->has('created.human')
                        ->has('created.string')
                        ->has('user.id')
                        ->has('user.details.name')
                        ->has('user.details.handle')
                        ->has('user.details.email.address')
                        ->has('user.details.status')
                        ->has('user.created.human')
                        ->has('user.created.string')
                        ->etc(),
                )->etc(),
        );
    });
    test('the threads show payload contains the expected data', function (): void {
        $thread = Thread::factory()->create();

        actingAs(User::factory()->create())->getJson(
            uri: action(Controllers\Threads\ShowController::class, $thread->id),
        )->assertOk()->assertJson(
            fn(AssertableJson $json) => $json
                ->has('id')
                ->has('content.body')
                ->has('content.meta')
                ->has('content.reactions')
                ->has('content.views')
                ->has('created.human')
                ->has('created.string')
                ->etc(),
        );
    });
})->group('threads', 'posting');

describe('creating and managing replies', function (): void {
    test('as an authenticated user I can reply to a thread', function (): void {
        Bus::fake();
        $thread = Thread::factory()->create();

        actingAs(User::factory()->create())->postJson(
            uri: action(Controllers\Replies\StoreController::class, $thread->id),
            data: [
                'body' => 'This is a reply to the thread.',
            ],
        )->assertAccepted()->assertJson(
            fn(AssertableJson $json) => $json
                ->has('message')
                ->where('message', 'Reply is being processed.')
                ->etc(),
        );

        Bus::assertDispatched(
            command: ReplyToThread::class,
        );
    });

    test('when a reply is created an event is stored', function (): void {
        $user = User::factory()->create();
        $thread = Thread::factory()->for($user)->create();
        $replyDTO = new NewReply(
            thread: $thread->id,
            user: $user->id,
            body: 'This is a reply to the thread',
        );

        ThreadAggregate::fake()->given(
            events: new ThreadWasReplied(
                reply: $replyDTO,
            ),
        )->when(function (ThreadAggregate $aggregate) use ($replyDTO): string {
            $aggregate->replyToThread($replyDTO);

            return $aggregate->uuid();
        })->assertRecorded(expectedEvents: [new ThreadWasReplied($replyDTO)]);
    });
})->group('replies', 'posting');
