<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearThemeAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:clear-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除建立的软链接';

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
        $themesAssets = scandir(resource_path('themes'));
        foreach ($themesAssets as $theme){
            if($theme === '.' || $theme === '..'){
                continue;
            }
            $linkPath = public_path('assets/theme/'.$theme);
//            if (is_link($linkPath) || (windows_os() && file_exists($linkPath) && linkinfo($linkPath))) {
//
//            }
            if (is_link($linkPath)){ //TODO Windows会创建硬链接 无法删除
                unlink($linkPath);
            }
        }
        return 0;
    }
}
