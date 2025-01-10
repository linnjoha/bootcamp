<?php

use Illuminate\Support\Facades\Log;
use App\Models\User;

test('a log is created when another user creates a chirp', function () {
    Log::fake();

    $user = User::factory()->create();
    $this->actingAs($user);

    $this->post(route('chirps.store'), [
        'message' => 'chirpechirp',
    ]);

    Log::assertLogged('info', function ($message) {
        return str_contains($message, 'New chirp created by');
    });
});
