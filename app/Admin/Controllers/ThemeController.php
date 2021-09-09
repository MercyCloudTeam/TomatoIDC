<?php

namespace App\Admin\Controllers;

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
use Illuminate\Support\Facades\Storage;

class ThemeController extends AdminController
{
    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function setupShow()
    {
        $content = new Content();
//        return $content
//            ->description($this->description()['show'] ?? trans('admin.show'))
//            ->body(Grid::make(new SystemSetup()));

//        $form = Form::make(null,function (Form $form){
//            $config = SetupManager::getThemeConfig();
//            foreach ($config->variable as $name=>$type){
//                switch ($type){
//                    case 'string':
//                        $form->input($name);
//                }
//            }
//            return $form;
//        });
//        //获取配置项
//
//        $content = new Content();
////        $form = new Form();
////        $config = SetupManager::getThemeConfig();
////        foreach ($config->variable as $name=>$type){
////            switch ($type){
////                case 'string':
////                    $form->input($name);
////            }
////        }
////        dd($form);
//        return $content->body($form);
    }

    public function setupUpdate()
    {
//        SystemSetup::updateOrCreate(['key'=>''],)
    }
}
