<?php

//Reference：https://github.com/oneso/laravel-plugins
//Modified date： 2021.08.24
//Modifier: YFsama[yf@mercycloud.com]

namespace App\Plugins;


use Illuminate\Contracts\Filesystem\FileNotFoundException;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Finder\SplFileInfo;
use function Composer\Autoload\includeFile;

class PluginExtender
{
    protected $app;

    /**
     * @var PluginManager
     */
    protected PluginManager $pluginManager;

    /**
     * @var string
     */
    protected string $classMapCacheFile;

    /**
     * PluginExtender constructor.
     *
     * @param PluginManager $pluginManager
     * @param $app
     */
    public function __construct(PluginManager $pluginManager, $app)
    {
        $this->pluginManager     = $pluginManager;
        $this->app               = $app;
        $this->classMapCacheFile = storage_path('plugins/classmap.json');
    }

    /**
     * Extends all plugins.
     */
    public function extendAll()
    {
        if (!$this->load()) {
            foreach ($this->pluginManager->getPlugins() as $plugin) {
                $this->extend($plugin, false);
            }

            $this->writeCache();
        }
    }

    /**
     * Search for plugin extensions.
     *
     * @param Plugin $plugin
     * @param bool $writeCache
     * @throws ReflectionException
     */
    public function extend(Plugin $plugin, bool $writeCache = true)
    {
        foreach ($this->getAllPluginClasses($plugin) as $pluginClassPath) {
            $classNamespace = $this->getClassNamespaceFromFilename($pluginClassPath);

            // we cannot redeclare classes
            if ($this->classExists($classNamespace)) {
                continue;
            }

            $addMethods          = [];
            $beforeReturnMethods = [];
            $contants            = [];

            foreach ($this->getExtensionFilesForFile($pluginClassPath, $plugin) as $file) {
                includeFile($file);

                $extendingClassNamespace = $this->getClassNamespaceFromFilename($file);

                $fileContent = $this->app['files']->get($file);
                $reflector   = new ReflectionClass($extendingClassNamespace);

                $addMethods = array_merge(
                    $addMethods,
                    $this->collectMethodsOfType('add', $fileContent, $reflector)
                );

                $beforeReturnMethods = array_merge(
                    $beforeReturnMethods,
                    $this->collectMethodsOfType('beforeReturn', $fileContent, $reflector)
                );

                $contants = array_merge($contants, $this->collectConstants($reflector));
            }

            if ($addMethods || $beforeReturnMethods || $contants) {
                $originalFileContent         = $this->app['files']->get($pluginClassPath);
                $originalFileContentExploded = explode(PHP_EOL, $originalFileContent);

                $this->removeLastBracket($originalFileContentExploded);

                if ($addMethods) {
                    $this->insertAddMethods($addMethods, $originalFileContentExploded);
                }

                if ($beforeReturnMethods) {
                    $this->insertBeforeReturnMethods($beforeReturnMethods, $originalFileContentExploded);
                }

                if ($contants) {
                    $this->insertConstants($contants, $originalFileContentExploded);
                }

                $originalFileContentExploded[] = '}';

                $newFileContent = implode(PHP_EOL, $originalFileContentExploded);
                $storagePath    = $this->getExtendedClassStoragePath($pluginClassPath);

                $this->app['files']->put($storagePath, $newFileContent);

                $this->pluginManager->addClassMapping($classNamespace, $storagePath);
            }
        }

        if ($writeCache) {
            $this->writeCache();
        }
    }

    /**
     * @param array $target
     */
    protected function removeLastBracket(array &$target)
    {
        if (false !== $index = $this->getIndexForFirstOccurence('}', array_reverse($target, true))) {
            unset($target[$index]);
        }
    }

    /**
     * @param $search
     * @param array $subject
     * @return bool|int
     */
    protected function getIndexForFirstOccurence($search, array $subject): bool|int
    {
        foreach ($subject as $key => $value) {
            if (str_contains($value, $search)) {
                return $key;
            }
        }

        return false;
    }

    /**
     * @param array $methods
     * @param array $fileContentExploded
     */
    protected function insertAddMethods(array $methods, array &$fileContentExploded)
    {
        $fileContentExploded = array_merge($fileContentExploded, [''], $methods);
    }

    /**
     * @param array $methods
     * @param array $fileContentExploded
     */
    protected function insertBeforeReturnMethods(array $methods, array &$fileContentExploded)
    {
        foreach ($methods as $method) {
            $methodExploded = explode(PHP_EOL, $method);

            $innerStart = $this->getIndexForFirstOccurence('{', $methodExploded) + 1;
            $innerEnd   = $this->getIndexForFirstOccurence('}', array_reverse($methodExploded, true)) - 1;

            $inner = array_slice($methodExploded, $innerStart, $innerEnd - $innerStart + 1);

            if (false == $methodName = $this->getMethodNameFromString($method)) {
                continue;
            }

            $originalMethodStartIndex  = $this->getIndexForFirstOccurence($methodName, $fileContentExploded);
            $originalMethodReturnIndex = $this->getIndexForFirstOccurence(
                'return',
                array_slice($fileContentExploded, $originalMethodStartIndex, null, true)
            );

            $fileContentBeforeReturn = array_slice($fileContentExploded, 0, $originalMethodReturnIndex);
            $fileContentAfterReturn  = array_slice($fileContentExploded, $originalMethodReturnIndex);
            $fileContentExploded     = array_merge($fileContentBeforeReturn, $inner, [''], $fileContentAfterReturn);
        }
    }

    /**
     * @param $string
     * @return bool|string
     */
    protected function getMethodNameFromString($string): bool|string
    {
        preg_match('/.*function\s+(.*)\(.*/i', $string, $methodName);

        return $methodName[1] ?? false;
    }

    /**
     * @param array $constants
     * @param array $fileContentExploded
     */
    protected function insertConstants(array $constants, array &$fileContentExploded)
    {
        $lastConstantIndex = $this->getIndexForFirstOccurence('const', array_reverse($fileContentExploded, true));

        if ($lastConstantIndex === false) {
            $lastConstantIndex = $this->getIndexForFirstOccurence('{', $fileContentExploded);
        }

        if ($lastConstantIndex !== false) {
            $before = array_slice($fileContentExploded, 0, $lastConstantIndex + 1);
            $after  = array_slice($fileContentExploded, $lastConstantIndex + 1);

            $fileContentExploded = $before;

            foreach ($constants as $constantName => $constantValue) {
                if (is_bool($constantValue)) {
                    $constantValue = $constantValue ? 'true' : 'false';
                } elseif (is_array($constantValue)) {
                    $constantValue = '[' . implode(',', $constantValue) . ']';
                }

                $fileContentExploded[] = '    const ' . $constantName . ' = ' . $constantValue . ';';
            }

            $fileContentExploded = array_merge($fileContentExploded, $after);
        }
    }

    /**
     * @param string $type
     * @param $fileContent
     * @param ReflectionClass $reflector
     * @return array
     */
    protected function collectMethodsOfType($type, $fileContent, ReflectionClass $reflector): array
    {
        $methods = [];

        $fileContentExploded = explode(PHP_EOL, $fileContent);

        foreach ($reflector->getMethods() as $reflectionMethod) {

            $doc = $reflectionMethod->getDocComment();

            if (str_contains($doc, '@' . $type)) {
                $methods[] = $this->getMethodString($reflectionMethod, $fileContentExploded);
            }
        }

        return $methods;
    }

    /**
     * @param ReflectionClass $reflactor
     * @return array
     */
    #[Pure] protected function collectConstants(ReflectionClass $reflactor): array
    {
        return $reflactor->getConstants();
    }

    /**
     * @param \ReflectionMethod $method
     * @param array $splittedContent
     * @return string
     */
    #[Pure] protected function getMethodString(\ReflectionMethod $method, array $splittedContent): string
    {
        $methodString = '';

        for ($i = $method->getStartLine(); $i <= $method->getEndLine(); $i++) {
            $methodString .= $splittedContent[$i - 1] . PHP_EOL;
        }

        return $methodString;
    }

    /**
     * @param Plugin $plugin
     * @return array
     */
    protected function getAllPluginClasses(Plugin $plugin): array
    {
        $files = [];

        foreach ($this->app['files']->allFiles($plugin->getPluginPath()) as $file) {
            /** @var SplFileInfo $file */

            if (!$this->fileContainsClass($file->getContents())) {
                continue;
            }

            $files[] = $file->getPathname();
        }

        return $files;
    }

    /**
     * @param $file
     * @param Plugin $plugin
     * @return array
     */
    protected function getExtensionFilesForFile($file, Plugin $plugin): array
    {
        $files     = [];
        $classPath = str_replace($this->pluginManager->getPluginDirectory(), DIRECTORY_SEPARATOR . 'Plugins', $file);

        foreach ($this->pluginManager->getPlugins() as $otherPlugin) {
            /** @var Plugin $otherPlugin */

            if ($plugin->name == $otherPlugin->name) {
                continue;
            }

            $extensionFilePath = $otherPlugin->getPluginPath() . $classPath;

            if (!$this->app['files']->exists($extensionFilePath)) {
                continue;
            }

            $files[] = $extensionFilePath;
        }

        return $files;
    }

    /**
     * @param $file
     * @return bool
     */
    protected function fileContainsClass($file): bool
    {
        $tokens = token_get_all($file);

        foreach ($tokens as $idx => $token) {
            if (is_array($token)) {
                if (token_name($token[0]) == 'T_CLASS' &&
                    token_name($tokens[$idx-1][0]) != 'T_DOUBLE_COLON') {

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param $file
     * @return string
     */
    protected function getClassNamespaceFromFilename($file): string
    {
        $namespace = str_replace($this->pluginManager->getPluginDirectory(), 'HStack\\Plugins', $file);
        $namespace = str_replace('/', '\\', $namespace);
        $namespace = str_replace('.php', '', $namespace);

        return $namespace;
    }

    /**
     * @param $file
     * @return string
     */
    protected function getExtendedClassStoragePath($file): string
    {
        $classNamespace = $this->getClassNamespaceFromFilename($file);

        return storage_path(
            'plugins'
            . DIRECTORY_SEPARATOR
            . str_replace('\\', '_', $classNamespace)
            . '.php'
        );
    }

    /**
     * @param $class
     * @param bool $autoload
     * @return bool
     */
    protected function classExists($class, bool $autoload = false): bool
    {
        return class_exists($class, $autoload);
    }

    /**
     * @return bool
     */
    protected function load(): bool
    {
        if (!env('PLUGIN_CACHE', true)) {
            return false;
        }

        try {
            $this->pluginManager->setClassMap(json_decode($this->app['files']->get($this->classMapCacheFile), true));
        } catch (FileNotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * @return int
     */
    protected function writeCache(): int
    {
        return $this->app['files']->put($this->classMapCacheFile, json_encode($this->pluginManager->getClassMap()));
    }
}
