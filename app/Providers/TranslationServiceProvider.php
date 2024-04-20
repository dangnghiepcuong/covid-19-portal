<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * The path to the current lang files.
     *
     * @var string
     */
    protected $langPath;

    /**
     * Create a new service provider instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->langPath = resource_path('lang/');
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $translation = [];
        // open resources/lang
        $folder = opendir($this->langPath);
        // read every subfolder
        while (($subfolder = readdir($folder)) !== false) {
            // check whether it is a valid directory (a lang directory)
            if ($subfolder === '.' || $subfolder === '..') {
                continue;
            }

            $directory = $this->langPath . '/' . $subfolder . '/';
            if (!is_dir($directory)) {
                continue;
            }

            $langData = [];
            // read every file in this lang directory
            $file = opendir($directory);
            if (!$file) {
                continue;
            }

            while (($filename = readdir($file)) !== false) {
                if ($filename === '.' || $filename === '..') {
                    continue;
                }

                // read file which return data
                $data = include $directory . $filename;

                // file name as key
                $dictName = substr($filename, 0, strlen($filename) - 4);
                $langData[$dictName] = $data;
            }

            // add a language translation
            $translation[$subfolder] = $langData;
        }

        View::share('translation', json_encode($translation));
    }
}
