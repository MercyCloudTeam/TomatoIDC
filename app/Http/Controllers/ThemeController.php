<?php

namespace App\Http\Controllers;

use App\SettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ThemeController extends Controller
{

    /**
     * 获取服务器主题
     * @return array
     */
    public static function getThemeArr()
    {
        $path = base_path('resources/views/themes');
        $fileTemp = scandir($path);
        $fileList = [];
        foreach ($fileTemp as $value) {
            if ($value != '.' && $value != '..') {
                array_push($fileList, $value);
            }
        }
        return $fileList;
    }

    /**
     * 获取服务器主题
     * @return array
     */
    public static function getAdminThemeArr()
    {
        $path = base_path('resources/views/admin/themes/');
        $fileTemp = scandir($path);
        $fileList = [];
        foreach ($fileTemp as $value) {
            if ($value != '.' && $value != '..') {
                array_push($fileList, $value);
            }
        }
        return $fileList;
    }

    /**
     * 返回当前使用的模版名
     * @return string 当前使用的模版名
     */
    public static function getThemeName()
    {
        $themes = SettingModel::where('name','setting.website.theme')->get();
        if ($themes->first()) {
            return $themes->first()->value;
        }
        return 'default';
    }

    /**
     * 返回视图
     * @param string $viewName 文件名
     * @param null $prefix 子文件夹 可为空
     * @return string 返回视图
     */
    public static function backThemePath($viewName = 'index', $prefix = null)
    {
        //SPA单页应用
        $spa = SettingModel::where('name', 'setting.website.spa.status')->get();
        if (!$spa->isEmpty()) {
            if ($spa->first()->value == 1) {
                $path = 'themes.' . self::getThemeName() . '.index';
                if (View::exists($path)) {
                    return $path;
                }
                return 'themes.default.index';
            }
        }
        //模
        //版返回
        empty($prefix) ?: $prefix = '.' . $prefix;
        $path = 'themes.' . self::getThemeName() . $prefix . '.' . $viewName;
        if (View::exists($path)) {
            return $path;
        }
        //没有该模板的时候使用default模板
        if (View::exists('themes.default' . $prefix . '.' . $viewName)) {
            return 'themes.default' . $prefix . '.' . $viewName;
        }
        return 'themes.default.index';
    }


    /**
     * 返回当前使用管理员的模版名
     * @return string 当前使用的模版名
     */
    public static function getAdminThemeName()
    {
        $themes = SettingModel::where('name', '=', 'setting.website.admin.theme')->get();
        if ($themes->first()) {
            return $themes->first()->value;
        }
        return 'default';
    }

    /**
     * 返回管理员视图
     * @param string $viewName 文件名
     * @param null $prefix 子文件夹 可为空
     * @return string 返回视图
     */
    public static function backAdminThemePath($viewName = 'index', $prefix = null)
    {
        empty($prefix) ?: $prefix = '.' . $prefix;
        $path = 'admin.themes.' . self::getThemeName() . $prefix . '.' . $viewName;
        if (View::exists($path)) {
            return $path;
        }
        //没有该模板的时候使用default模板
        if (View::exists('admin.themes.default' . $prefix . '.' . $viewName)) {
            return 'admin.themes.default' . $prefix . '.' . $viewName;
        }
        return 'themes.default.index';
    }

    public function setThemeName(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|min:3|max:32'
        ]);
//        $path = resource_path();

    }
}
