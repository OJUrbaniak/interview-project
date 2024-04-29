<?php

namespace App\Repositories;
use App\Interfaces\PropertyInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class PropertyRepository implements PropertyInterface
{
    /**
     * @return array
     */
    public function getAllProperties(): array
    {
        return DB::select(
            <<<SQL
            SELECT l.location_name, p.* FROM sykes_interview.properties p
            INNER JOIN sykes_interview.locations l on p._fk_location = l.__pk
            SQL
        );
    }

    /**
     * @param string|null $location
     * @param bool $nearBeach
     * @param bool $acceptsPets
     * @param int|null $sleepsMin
     * @param int|null $bedsMin
     * @param Date|null $fromDate
     * @param Date|null $toDate
     * @return mixed
     */
    public function getPropertiesWithFilter(
        string $location = null,
        bool $nearBeach = null,
        bool $acceptsPets = null,
        int $sleepsMin = null,
        int $bedsMin = null,
        string $fromDate = null,
        string $toDate = null,
    ): array
    {
        $sql = <<<SQL
            SELECT DISTINCT l.location_name, p.* FROM sykes_interview.properties p
            INNER JOIN sykes_interview.locations l on p._fk_location = l.__pk
            INNER JOIN sykes_interview.bookings b on p.`__pk` = b.`_fk_property` 
            SQL;

        if ($location) {
            $location = "%$location%";
            $sql .= <<<SQL
            \nWHERE location_name LIKE ?
            SQL;
        }

        if ($nearBeach) {
            $sql .= <<<SQL
            \nAND near_beach = $nearBeach
            SQL;
        }

        if ($acceptsPets) {
            $sql .= <<<SQL
            \nAND accepts_pets = $acceptsPets
            SQL;
        }

        if ($sleepsMin) {
            $sql .= <<<SQL
            \nAND sleeps >= $sleepsMin
            SQL;
        }

        if ($bedsMin) {
            $sql .= <<<SQL
            \nAND beds >= $bedsMin
            SQL;
        }

        if ($fromDate && $toDate) {
            $sql .= <<<SQL
            \nAND NOT ('$fromDate' <= b.end_date AND '$toDate' >= b.start_date);
            SQL;
        }

        return DB::select(
            $sql,
            [$location]
        );
    }
}
