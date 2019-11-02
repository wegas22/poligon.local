<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoreRepository
 * @package App\Repositories
 *
 * Репоситорий работы с сущностью
 * Может выдавать наборы данных
 * Не может создавать и изминять сущности
 */

abstract class CoreRepository
{
    /**
     * @var Model
     */
    protected $model;
    /**
     * Core Repository constructor
     */
    public function __construct()
    {
        return $this->model = app($this->getModelClass());
    }
    /**
     * @return mixed
     */
    abstract protected function getModelClass();
    /**
     * @return Model|\Illuminate\Foundation\Application|mixed
     */
    protected function startConditions()
    {
        return clone $this->model;
    }
}
