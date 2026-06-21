<?php

namespace App\Providers;

use App\Contracts\Services\AboutServiceInterface;
use App\Contracts\Services\ArchiveServiceInterface;
use App\Contracts\Services\CartServiceInterface;
use App\Contracts\Services\CheckoutServiceInterface;
use App\Contracts\Services\CollectionServiceInterface;
use App\Contracts\Services\ConfirmationServiceInterface;
use App\Contracts\Services\ContactServiceInterface;
use App\Contracts\Services\ContentServiceInterface;
use App\Contracts\Services\HomePageServiceInterface;
use App\Contracts\Services\ProductServiceInterface;
use App\Services\AboutService;
use App\Services\ArchiveService;
use App\Services\CheckoutService;
use App\Services\ConfirmationService;
use App\Services\CartService;
use App\Services\CollectionService;
use App\Services\ContactService;
use App\Services\ContentService;
use App\Services\HomePageService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(HomePageServiceInterface::class, HomePageService::class);
        $this->app->bind(CollectionServiceInterface::class, CollectionService::class);
        $this->app->bind(AboutServiceInterface::class, AboutService::class);
        $this->app->bind(ArchiveServiceInterface::class, ArchiveService::class);
        $this->app->bind(ContactServiceInterface::class, ContactService::class);
        $this->app->bind(CartServiceInterface::class, CartService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(CheckoutServiceInterface::class, CheckoutService::class);
        $this->app->bind(ConfirmationServiceInterface::class, ConfirmationService::class);
        $this->app->bind(ContentServiceInterface::class, ContentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
