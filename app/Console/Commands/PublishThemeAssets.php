<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
    protected $description = '发布主题静态文件';

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
        return 0;
    }
}
