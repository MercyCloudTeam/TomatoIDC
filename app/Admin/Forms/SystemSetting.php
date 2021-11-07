<?php

namespace App\Admin\Forms;

use App\HStack\SetupManager;
use App\Models\SystemSetup;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class SystemSetting extends Form
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
        //删除缓存
//        if (Cache::has('site-setups')){
        try {
            Cache::delete( 'site-setups');//删除缓存
        }catch (\Exception $exception){

        }
//        }
        //存储
        foreach ($input as $k=>$v){
            SystemSetup::updateOrCreate([
                'name'=>$k,
                'type'=>'system',
            ], [
                'value'=>$v
            ]);
        }
        return $this->response()->success('设置成功')->location();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        foreach (config('hstack.system.setups') as $name=>$arr){
//            dd(config('hstack.system.setups') );
            if (isset($arr['input'])){
                switch ($arr['input']){
                    case "image":
                        $this->image($name,__($arr['lang'] ?? $name));
                        break;
                    case "switch":
                        $this->switch($name,__($arr['lang'] ?? $name));
                        break;
                    default:
                        $this->text($name,__($arr['lang'] ?? $name));
                }
            }

        }
    }


    public function
    default()
    {
        if (admin_setting('body_class', 0)) {
            $body_class = 0;
        } else {
            $body_class = 1;
        }
        $setup = SystemSetup::where('type','system')->get();
        $variables = [];
        if (!$setup->isEmpty()){
            foreach ($setup->pluck('value','name') as $k=>$v){
                $variables[$k] = $v;
            }
        }
        return array_merge(['body_class' => $body_class],$variables);
    }
}
