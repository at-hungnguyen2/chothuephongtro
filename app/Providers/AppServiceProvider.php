<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;
use App\Room;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserPasswordChanged;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Room::updated(function($room) {
            $roomOriginal = $room->getOriginal();
            if (array_key_exists('status', $room->getDirty())) {
                $post = Post::findOrFail($roomOriginal['post_id']);
                
                $roomsReady = $post->rooms()->where('status', 1)->count();

                if (!$roomsReady) {
                    $post->status = 0;
                    $post->save();
                }
                if ($roomsReady && $post->status == 0) {
                    $post->status = 1;
                    $post->save();
                }
            }
        });

        Room::deleted(function($room) {
            $roomOriginal = $room->getOriginal();
            
            $post = Post::findOrFail($roomOriginal['post_id']);
                
            $roomsReady = $post->rooms()->where('status', 1)->count();

            if (!$roomsReady) {
                $post->status = 0;
                $post->save();
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserEloquentRepository::class
        );
    }
}
