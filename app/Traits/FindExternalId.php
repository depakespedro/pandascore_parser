<?php

namespace App\Traits;

trait FindExternalId
{
    public function scopeFindByExternalId($q, $code)
    {
        return $q->where('external_id', $code);
    }
}
