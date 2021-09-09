<?php

namespace App\Admin\Repositories;

use App\Models\SystemSetup as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class SystemSetup extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
