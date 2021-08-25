<?php

namespace App\Admin\Repositories;

use App\Models\Billing as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Billing extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
