<?php

declare(strict_types=1);

use App\Filament\Resources\UserResource;
use App\Models\User;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    login();
});

it('can render index page of the Bookmark resource.', function () {
    // Act & Assert
    get(UserResource::getUrl())->assertOk();
});

it('can list users in the table.', function () {
    // Arrange
    $user = User::all();

    livewire(UserResource\Pages\ListUsers::class)
        ->assertCanSeeTableRecords($user)
        ->assertTableActionExists('view')
        ->assertTableActionExists('edit')
        ->assertTableActionDoesNotExist('delete');
});

it('can render create user page.', function () {
    // Act & Assert
    get(UserResource::getUrl('create'))
        ->assertOk();
});

it('can render edit user page.', function () {
    // Act & Assert
    get(UserResource::getUrl('edit', [
        'record' => User::factory()->create(),
    ]))
        ->assertSuccessful();
});

it('can render view user page.', function () {
    // Act & Assert
    get(UserResource::getUrl('view', [
        'record' => User::factory()->create(),
    ]))
        ->assertSuccessful();
});

it('can create a new user.', function () {
    // Arrange
    $user = User::factory()->make();

    // Act & Assert
    livewire(UserResource\Pages\CreateUser::class)
        ->fillForm([
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->call('create')
        ->assertHasNoFormErrors();
});

it('can update user model.', function () {
    // Arrange
    $user = User::factory()->create();
    $newUser = User::factory()->make();

    // Act & Assert
    livewire(UserResource\Pages\EditUser::class, [
        'record' => $user->getKey(),
    ])
        ->fillForm([
            'name' => $newUser->name,
            'email' => $newUser->email,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->refresh())
        ->name->toBe($newUser->name)
        ->email->toBe($newUser->email);
});
