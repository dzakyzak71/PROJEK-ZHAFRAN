<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;
use Google\Client;
use Google\Service\Drive;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

   
    public function boot(): void
    {
        // Custom directive @role
        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole($role)): ?>";
                  });

                Storage::extend('google', function ($app, $config) {
                    $client = new Client();
                    $client->setClientId($config['clientId']);
                    $client->setClientSecret($config['clientSecret']);
                    $client->refreshToken($config['refreshToken']);

                    $service = new Drive($client);
                    $adapter = new GoogleDriveAdapter($service, $config['folderId'] ?? null);

                    return new Filesystem($adapter);
                     });
      

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });
    }
}
