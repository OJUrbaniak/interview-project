<?php

namespace App\Interfaces;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

interface PropertyInterface
{
    public function getAllProperties();
    public function getPropertiesWithFilter(
        string $location,
        bool $nearBeach,
        bool $acceptsPets,
        int $sleepsMin,
        int $bedsMin,
        string $fromDate,
        string $toDate,
    );
}