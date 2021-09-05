<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use App\Models\SystemSetup;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Storage;

class ThemeController extends AdminController
{
    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function setupShow()
    {
        $theme = config('hstack.theme');
        $path = resource_path("themes/$theme");
        $configFilePath  = "$path/theme.json";
        if (Storage::exists($configFilePath)){
            Storage::get($configFilePath);
        }
        $config = json_decode();
        //获取配置项

    }

    public function setupUpdate()
    {
//        SystemSetup::updateOrCreate(['key'=>''],)
    }
}
