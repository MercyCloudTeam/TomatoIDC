<?php

namespace App\HStack;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class MenuManager
{
    public array $list;

    public function __construct()
    {
        $this->list = $this->getDefaultMenu();
    }

    /**
     * 获取默认的菜单
     * @return array
     */
    public function getDefaultMenu(): array
    {
        return [];
    }
    /**
     * 注册菜单
     * @param string $name
     * @param string $url
     */
    public function registerMenu(string $name,string $url)
    {
        $this->list[$name] = $url;
    }



}
