<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Policies\IngredientPolicy;
use App\Policies\RecipePolicy;
use App\Policies\StepPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin-ingredient', [IngredientPolicy::class, 'admin']);
        Gate::define('create-ingredient', [IngredientPolicy::class, 'create']);
        Gate::define('admin-step', [StepPolicy::class, 'admin']);
        Gate::define('create-step', [StepPolicy::class, 'create']);
        Gate::define('admin-recipe', [RecipePolicy::class, 'admin']);
    }
}
