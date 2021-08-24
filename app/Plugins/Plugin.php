<?php

//Reference：https://github.com/oneso/laravel-plugins
//Modified date： 2021.08.24
//Modifier: YFsama[yf@mercycloud.com]

namespace App\Plugins;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
use Illuminate\View\View;
use ReflectionClass;

abstract class Plugin
{
    protected $app;

    /**
     * The Plugin Name.
     *
     * @var string
     */
    public string $name;


    /**
     * 作者
     * @var string
     */
    public string $author;

    /**
     * A description of the plugin.
     *
     * @var string
     */
    public string $description;

    /**
     * The version of the plugin.
     *
     * @var string
     */
    public string $version;

    /**
     * @var $this
     */
    private $reflector = null;

    /**
     * Plugin constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->checkPluginName();
    }

    abstract public function boot();

    /**
     * Check for empty plugin name.
     *
     * @throws \InvalidArgumentException
     */
    private function checkPluginName()
    {
        if (!$this->name) {
            throw new \InvalidArgumentException('Missing Plugin name.');
        }
    }

    /**
     * Returns the view namespace in a camel case format based off
     * the plugins class name, with plugin stripped off the end.
     *
     * Eg: ArticlesPlugin will be accessible through 'plugin:articles::<view name>'
     *
     * @return string
     */
    protected function getViewNamespace(): string
    {
        return 'plugin:' . Str::camel(
                mb_substr(
                    get_called_class(),
                    strrpos(get_called_class(), '\\') + 1,
                    -6
                )
            );
    }

    /**
     * Add a view namespace for this plugin.
     * Eg: view("plugin:articles::{view_name}")
     *
     * @param string $path
     */
    protected function enableViews(string $path = 'views')
    {
        $this->app['view']->addNamespace(
            $this->getViewNamespace(),
            $this->getPluginPath() . DIRECTORY_SEPARATOR . $path
        );
    }

    /**
     * Enable routes for this plugin.
     *
     * @param string $path
     * @param array|string $middleware
     */
    protected function enableRoutes(string $path = 'routes.php',  $middleware = 'web')
    {
        $this->app->router->group(
            [
                'namespace' => $this->getPluginControllerNamespace(),
                'middleware' => $middleware,
            ],
            function ($app) use ($path) {
                require $this->getPluginPath() . DIRECTORY_SEPARATOR . $path;
            }
        );
    }

    /**
     * Register a database migration path for this plugin.
     *
     * @param array|string $paths
     * @return void
     */
    protected function enableMigrations($paths = 'migrations')
    {
        $this->app->afterResolving('migrator', function ($migrator) use ($paths) {
            foreach ((array) $paths as $path) {
                $migrator->path($this->getPluginPath() . DIRECTORY_SEPARATOR . $path);
            }
        });
    }

    /**
     * Add a translations namespace for this plugin.
     * Eg: __("plugin:articles::{trans_path}")
     *
     * @param string $path
     */
    protected function enableTranslations(string $path = 'lang')
    {
        $this->app->afterResolving('translator', function ($translator) use ($path) {
            $translator->addNamespace(
                $this->getViewNamespace(),
                $this->getPluginPath() . DIRECTORY_SEPARATOR . $path
            );
        });
    }

    /**
     * @return string
     */
    public function getPluginPath(): string
    {
        $reflector = $this->getReflector();
        $fileName  = $reflector->getFileName();

        return dirname($fileName);
    }

    /**
     * @return string
     */
    protected function getPluginControllerNamespace(): string
    {
        $reflector = $this->getReflector();
        $baseDir   = str_replace($reflector->getShortName(), '', $reflector->getName());

        return $baseDir . 'Http\\Controllers';
    }

    /**
     * @return ReflectionClass
     */
    private function getReflector(): ReflectionClass
    {
        if (is_null($this->reflector)) {
            $this->reflector = new ReflectionClass($this);
        }

        return $this->reflector;
    }

    /**
     * Returns a plugin view
     *
     * @param $view
     * @return View
     */
    protected function view($view): View
    {
        return view($this->getViewNamespace() . '::' . $view);
    }
}
