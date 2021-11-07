<?php

namespace App\Admin\Forms;

use App\HStack\SetupManager;
use App\Models\SystemSetup;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class ThemeSetting extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return JsonResponse
     * @throws InvalidArgumentException
     */
    public function handle(array $input)
    {

        $theme = config('hstack.theme');
        //删除缓存
        if (Cache::has("theme-$theme-variables")){
            Cache::delete( "theme-$theme-variables");//删除缓存
        }
        //存储
        foreach ($input as $k=>$v){
            SystemSetup::updateOrCreate([
                'name'=>$k,
                'type'=>'theme',
            ], [
                'value'=>$v
            ]);
        }
        return $this->response()->success('设置成功')->location('theme-setup');
    }

    /**
     * 获取配置文件
     * @param false $assoc
     * @return mixed
     */
    public function getFile(bool $assoc = false): mixed
    {
        $theme = config('hstack.theme');
        // 加载路径
        $file = resource_path("themes/$theme/theme.json");
        if (file_exists($file)) {
            $json = file_get_contents($file);
            Cache::put( "theme-$theme-json",$json);//如果没找到配置会注册个空的
            return json_decode($json,$assoc);
        }
        return false;
    }
    /**
     * Build a form here.
     */
    public function form()
    {
        $config = $this->getFile();
        if (!empty($config->variable)){
            $lang = $config->lang;

            foreach ($config->variable as $name=>$type){
                switch ($type){

                    case "switch":
                        $this->switch($name,$lang->{\App::getLocale()}->{$name} ?? $name);
                        break;
                    case "textarea":
                        $this->textarea($name,$lang->{\App::getLocale()}->{$name} ?? $name);
                        break;
                    default :
                        $this->text($name,$lang->{\App::getLocale()}->{$name} ?? $name);
                        break;
                }

            }
        }else{
            $this->display(null,'本模板无可配置项');
        }
    }


    public function default(): array
    {
        if (admin_setting('body_class', 0)) {
            $body_class = 0;
        } else {
            $body_class = 1;
        }
        $setup = SystemSetup::where('type','theme')->get();
        $variables = [];
        if (!$setup->isEmpty()){
            foreach ($setup->pluck('value','name') as $k=>$v){
                $variables[$k] = $v;
            }
        }
        return array_merge(['body_class' => $body_class],$variables);
    }
}
