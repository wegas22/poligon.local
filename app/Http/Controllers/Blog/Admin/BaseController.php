<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Blog\BaseController as GuestBaseController;

/**
 * Class BaseController
 * @package App\Http\Controllers\Blog\Admin
 * Базовый контроллер для всех контроллеров управления
 * блогом в панели администрирования.
 * Должен быть родителем для всех контроллеров управления блогом
 */
abstract class BaseController extends GuestBaseController
{
    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        //инициализация общих моментов
    }
}
