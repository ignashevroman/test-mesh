<?php

namespace App\Providers;

use App\Proxy\ModelManagerProxy;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Imports\ModelImporter;
use Maatwebsite\Excel\Validators\RowValidator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Bind our proxy ModelImporter class to be able to raise events
        $this->app->bind(ModelImporter::class, static function (Application $app) {
            return new ModelImporter(new ModelManagerProxy($app->make(RowValidator::class)));
        });
    }
}
