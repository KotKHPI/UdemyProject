<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use App\Models\CatName;
use App\Models\Comment;
use App\Observers\CatNameObserver;
use App\Observers\CommentObserve;
use App\Services\Counter;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::aliasComponent('components.badge', 'badge');
        Blade::aliasComponent('components.update', 'update');
        Blade::aliasComponent('components.card', 'card');
        Blade::aliasComponent('components.tags', 'tags');
        Blade::aliasComponent('components.errors', 'errors');
        Blade::aliasComponent('components.comment-form', 'commentForm');
        Blade::aliasComponent('components.comment-list', 'commentList');

        CatName::observe(CatNameObserver::class);
        Comment::observe(CommentObserve::class);

        $this->app->bind(Counter::class, function ($app) {
            return new Counter(5);
        });


        view()->composer(['home.cat', 'home.showCat'], ActivityComposer::class);
    }
}
