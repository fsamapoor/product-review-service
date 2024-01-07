<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\EnquiryServiceContract;
use App\Services\FakeEnquiryService;
use Illuminate\Support\ServiceProvider;

class EnquiryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EnquiryServiceContract::class, FakeEnquiryService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
