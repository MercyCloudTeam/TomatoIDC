<?php

namespace App\Admin\Repositories;

use App\Models\Service as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Service extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
