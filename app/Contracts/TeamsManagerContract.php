<?php

namespace App\Contracts;


use App\Team;

interface TeamsManagerContract
{
    /**
     * Создает либо возвращает команду по переданным параметрам
     * @param object $data - объект и сервиса pandascore
     * @return Team
     */
    public function firstOrCreate(object $data): Team;
}
