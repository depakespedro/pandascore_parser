<?php

namespace App\Contracts;


use App\Match;

interface MatchesManagerContract
{
    /**
     * Создает либо возвращает матч по переданным параметрам
     * @param object $data - объект и сервиса pandascore
     * @return Match
     */
    public function firstOrCreate(object $data): Match;
}
