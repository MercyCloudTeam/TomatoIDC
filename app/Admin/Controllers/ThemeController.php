<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ThemeSetting;
use App\Admin\Repositories\User;
use App\HStack\SetupManager;
use App\Models\SystemSetup;
use Dcat\Admin\Admin;
use Dcat\Admin\Contracts\Repository;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\Storage;

class ThemeController extends AdminController
{
    /**
     * 主题配置
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function setupShow(Content $content)
    {
        return  $content
            ->title('网站设置')
            ->description('详情')
            ->body(new Card(new ThemeSetting()));
    }

    public function setupUpdate()
    {
//        SystemSetup::updateOrCreate(['key'=>''],)
    }
}
