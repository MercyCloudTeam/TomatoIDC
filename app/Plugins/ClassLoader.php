<?php

//Reference：https://github.com/oneso/laravel-plugins
//Modified date： 2021.08.24
//Modifier: YFsama[yf@mercycloud.com]


namespace App\Plugins;


use function Composer\Autoload\includeFile;

class ClassLoader
{
    /**
     * @var PluginManager
     */
    protected PluginManager $pluginManager;

    /**
     * ClassLoader constructor.
     *
     * @param PluginManager $pluginManager
     */
    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    /**
     * Loads the given class or interface.
     *
     * @param $class
     * @return bool|null
     */
    public function loadClass($class): ?bool
    {
        if (isset($this->pluginManager->getClassMap()[$class])) {
            includeFile($this->pluginManager->getClassMap()[$class]);

            return true;
        }
        return null;
    }
}
