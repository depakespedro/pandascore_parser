<?php

namespace App\Contracts;


use App\League;

interface LeaguesManagerContract
{
    /**
     * Создает либо возвращает лигу по переданным параметрам
     * @param object $data - объект и сервиса pandascore
     * @return League
     */
    public function firstOrCreate(object $data): League;
}
