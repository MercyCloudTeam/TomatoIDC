<?php

namespace App\Admin\Repositories;

use App\Models\Ticket as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Ticket extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
