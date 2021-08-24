<?php

//Reference：https://github.com/oneso/laravel-plugins
//Modified date： 2021.08.24
//Modifier: YFsama[yf@mercycloud.com]

namespace App\Plugins;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class PluginManager
{
    private $app;

    /**
     * @var PluginManager
     */
    private static $instance = null;

    /**
     * @var string
     */
    protected string $pluginDirectory;

    /**
     * @var array
     */
    protected array $plugins = [];

    /**
     * @var array
     */
    protected array $classMap = [];

    /**
     * @var PluginExtender
     */
    protected $pluginExtender;

    /**
     * PluginManager constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->app             = $app;
        $this->pluginDirectory = base_path('Plugins');
        $this->pluginExtender  = new PluginExtender($this, $app);

        $this->bootPlugins();
        $this->pluginExtender->extendAll();

        $this->registerClassLoader();
    }

    /**
     * Registers plugin autoloader.
     */
    private function registerClassLoader()
    {
        spl_autoload_register([new ClassLoader($this), 'loadClass'], true, true);
    }

    /**
     * @param $app
     * @return PluginManager
     */
    public static function getInstance($app)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($app);
        }

        return self::$instance;
    }

    protected function bootPlugins()
    {
        foreach (Finder::create()->in($this->pluginDirectory)->directories()->depth(0) as $dir) {
            /** @var SplFileInfo $dir */
            $directoryName = $dir->getBasename();
            $pluginClass = $this->getPluginClassNameFromDirectory($directoryName);
            if (!class_exists($pluginClass)) {
                dd('Plugin ' . $directoryName . ' needs a ' . $directoryName . 'Plugin class.');
            }

            try {
                $plugin = $this->app->makeWith($pluginClass, [$this->app]);
            } catch (\ReflectionException $e) {
                dd('Plugin ' . $directoryName . ' could not be booted: "' . $e->getMessage() . '"');
                exit;
            }

            if (!($plugin instanceof Plugin)) {
                dd('Plugin ' . $directoryName . ' must extends the Plugin Base Class');
            }

            $plugin->boot();

            $this->plugins[$plugin->name] = $plugin;
        }
    }

    /**
     * @param $directory
     * @return string
     */
    protected function getPluginClassNameFromDirectory($directory): string
    {
        return "HStack\\Plugins\\${directory}\\${directory}Plugin";
    }

    /**
     * @return array
     */
    public function getClassMap(): array
    {
        return $this->classMap;
    }

    /**
     * @param array $classMap
     * @return $this
     */
    public function setClassMap(array $classMap): static
    {
        $this->classMap = $classMap;

        return $this;
    }

    /**
     * @param $classNamespace
     * @param $storagePath
     */
    public function addClassMapping($classNamespace, $storagePath)
    {
        $this->classMap[$classNamespace] = $storagePath;
    }

    /**
     * @return array
     */
    public function getPlugins(): array
    {
        return $this->plugins;
    }

    /**
     * @return string
     */
    public function getPluginDirectory(): string
    {
        return $this->pluginDirectory;
    }
}
