<?php

namespace App\Providers;

use App\Task;
use App\Project;
use App\Observers\TaskObeserver;
use App\Observers\ProjectObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Project::observe(ProjectObserver::class);
        Task::observe(TaskObeserver::class);
    }
}
