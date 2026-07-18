<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Topic;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // ⚡ Define Global Restriction Barrier Checks
        Gate::define('create-post', function (User $user) {
            return !in_array($user->status, ['restricted', 'blacklisted']) && !is_null($user->rules_accepted_at);
        });

        // ⚡ Define Discussion Resolution Ownership Checks
        Gate::define('manage-topic-resolution', function (User $user, Topic $topic) {
            return $user->id === $topic->user_id || in_array(strtolower(trim($user->role ?? '')), ['admin', 'administrator', 'lecturer']);
        });
    }
}