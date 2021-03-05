<?php

namespace App\Providers;

use App\Library\Facades\Encryption;
use App\Library\Facades\File;
use App\Library\Facades\Notification;
use App\Library\Modules\EncryptionModule;
use App\Library\Modules\FileModule;
use App\Library\Modules\NotificationModule;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Notification::class, NotificationModule::class);
        $this->app->bind(File::class, FileModule::class);
        $this->app->bind(Encryption::class, EncryptionModule::class);
    }
}
