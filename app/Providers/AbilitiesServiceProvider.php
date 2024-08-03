<?php

namespace App\Providers;

use App\Authorization\Abilities;
use App\Authorization\Role;
use App\Models\File;
use Exception;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;

use function Pest\Laravel\instance;

class AbilitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $files = glob(app_path('\Authorization\Abilities') . '/*.php');
        foreach ($files as $file) {
            // Extract the class name from the file name
            $className = basename($file, '.php');
            $fullClassName = 'App\Authorization\Abilities\\' . $className;

            if (!class_exists($fullClassName))
                throw new Exception("Abilities class $fullClassName do not exists", 500);

            $Abilities = new $fullClassName();

            if(!method_exists($Abilities, 'grant'))
                throw new Exception("Class $fullClassName do not contain grant method", 500);

            Abilities::grantAbilities($Abilities->grant());
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
