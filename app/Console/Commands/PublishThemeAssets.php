<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PublishThemeAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:assets-publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '发布主题静态文件（强制，当软链接无法建立的时候，硬复制）';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //未测试
        $src = resource_path('themes/' . config('hstack.theme') . '/assets');
        $dst = public_path('assets/theme/' . config('hstack.theme'));
        $this->copyDir($src,$dst);

        return 0;
    }

    /**
     * @param string $src
     * @param string $dst
     * @param bool $child
     * @return bool
     */
    public function copyDir(string $src, string $dst, bool $child = true): bool
    {
        if(!is_dir($src)){
            $this->info("Error:the $src is not a direction!");
            return false;
        }
        if(!is_dir($dst)){
            mkdir($dst);
        }
        $handle=dir($src);
        while($entry=$handle->read()) {
            if(($entry!=".")&&($entry!="..")){
                if(is_dir($src.DIRECTORY_SEPARATOR.$entry)){
                    if($child)
                        $this->copyDir($src.DIRECTORY_SEPARATOR.$entry,$dst.DIRECTORY_SEPARATOR.$entry,$child);
                }
                else{
                    copy($src.DIRECTORY_SEPARATOR.$entry,$dst.DIRECTORY_SEPARATOR.$entry);
                }
            }
        }
        return true;
    }
}
