<?php

namespace App\Repositories;
use App\Interfaces\PropertyInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class PropertyRepository implements PropertyInterface
{
    public $totalPages;

    public function getAllProperties()
    {
        return DB::select(
            <<<SQL
            SELECT
                l.location_name,
                p.property_name,
                p.near_beach,
                p.accepts_pets,
                p.sleeps,
                p.beds 
            FROM sykes_interview.properties p
            LEFT JOIN sykes_interview.locations l on p._fk_location = l.__pk
            SQL
        );
    }

    /**
     * @param string|null $location
     * @param bool $nearBeach
     * @param bool $acceptsPets
     * @param int|null $sleepsMin
     * @param int|null $bedsMin
     * @param string|null $fromDate
     * @param string|null $toDate
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
    ) {
        $sql = <<<SQL
            SELECT DISTINCT
                l.location_name,
                p.property_name,
                p.near_beach,
                p.accepts_pets,
                p.sleeps,
                p.beds 
            FROM sykes_interview.properties p
            INNER JOIN sykes_interview.locations l on p._fk_location = l.__pk
            LEFT JOIN sykes_interview.bookings b on p.`__pk` = b.`_fk_property` 
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
            \nAND (
                b.start_date IS NULL 
                OR
                NOT ('$fromDate' <= b.end_date AND '$toDate' >= b.start_date)
            )
            SQL;
        }

//        For a more complex implementation, an object to store property would be preferred

        return DB::select(
            $sql,
            $location ? [$location] : []
        );
    }
}
