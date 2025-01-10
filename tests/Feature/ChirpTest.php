<?php

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;


uses(RefreshDatabase::class);

test("a new chirp can be created", function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $message = [
        'message' => 'testing my cherpie derp',
    ];

    $response = $this->post(route('chirps.store'), $message);


    $response->assertRedirect(route('chirps.index'));


    $this->assertDatabaseHas('chirps', [
        'message' => 'testing my cherpie derp',
        'user_id' => $user->id,
    ]);
});



test("a chirp can be updated", function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $chirp = Chirp::factory()->create([
        'user_id' => $user->id,
        'message' => 'chiiiiirp',
    ]);
    $updatedChirp = [
        'message' => 'Updated cherpiiie',
    ];
    $response = $this->put(route('chirps.update', $chirp), $updatedChirp);
    $this->assertDatabaseHas('chirps', [
        'id' => $chirp->id,
        'message' => 'Updated cherpiiie',
    ]);
});

test('a user cant update a chirp when its not creater', function () {
    $ownerForChirp = User::factory()->create();
    $notOwnerforChirp = User::factory()->create();
    $this->actingAs($notOwnerforChirp);

    $chirp = Chirp::factory()->create([
        'user_id' => $ownerForChirp->id,
        'message' => 'og chirp',
    ]);

    $response = $this->put(route('chirps.update', $chirp), [
        'message' => 'new updated try chirp',
    ]);
    $response->assertForbidden();

    $this->assertDatabaseHas('chirps', [
        'id' => $chirp->id,
        'message' => 'og chirp',
    ]);
});

test("a chirp can be destoyed", function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $chirp = Chirp::factory()->create([
        'user_id' => $user->id,
    ]);
    $response = $this->delete(route('chirps.destroy', $chirp));

    $response->assertRedirect(route('chirps.index'));
    $this->assertDataBaseMissing('chirps', [
        'id' => $chirp->id
    ]);
});

test('a user cannot destroy someone elses chirp', function () {
    $ownerForChirp = User::factory()->create();
    $notOwnerforChirp = User::factory()->create();
    $this->actingAs($notOwnerforChirp);

    $chirp = Chirp::factory()->create([
        'user_id' => $ownerForChirp->id,
    ]);
    $response = $this->delete(route('chirps.destroy', $chirp));
    $response->assertForbidden();
    $this->assertDatabaseHas('chirps', [
        'id' => $chirp->id,
    ]);
});
