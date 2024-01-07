<?php

declare(strict_types=1);

use App\Filament\Resources\ProviderResource;
use App\Models\Provider;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    login();
});

it('can render index page of the Provider resource.', function () {
    // Act & Assert
    get(ProviderResource::getUrl())->assertOk();
});

it('can list provider names in the table.', function () {
    // Arrange
    $providers = Provider::factory()
        ->count(5)
        ->create();

    // Act & Assert
    livewire(ProviderResource\Pages\ListProviders::class)
        ->assertCanSeeTableRecords($providers)
        ->assertTableActionExists('view')
        ->assertTableActionExists('edit')
        ->assertTableActionDoesNotExist('delete');
});

it('can render create provider page.', function () {
    // Act & Assert
    get(ProviderResource::getUrl('create'))
        ->assertOk();
});

it('can render edit provider page.', function () {
    // Act & Assert
    get(ProviderResource::getUrl('edit', [
        'record' => Provider::factory()->create(),
    ]))
        ->assertSuccessful();
});

it('can render view provider page.', function () {
    // Act & Assert
    get(ProviderResource::getUrl('view', [
        'record' => Provider::factory()->create(),
    ]))
        ->assertSuccessful();
});

it('can create a new provider.', function () {
    // Arrange
    $provider = Provider::factory()->make();

    // Act & Assert
    livewire(ProviderResource\Pages\CreateProvider::class)
        ->fillForm([
            'name' => $provider->name,
        ])
        ->call('create')
        ->assertHasNoFormErrors();
});

it('can update provider model.', function () {
    // Arrange
    $provider = Provider::factory()->create();
    $newProvider = Provider::factory()->make();

    // Act & Assert
    livewire(ProviderResource\Pages\EditProvider::class, [
        'record' => $provider->getKey(),
    ])
        ->fillForm([
            'name' => $newProvider->name,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($provider->refresh())
        ->name->toBe($newProvider->name);
});
