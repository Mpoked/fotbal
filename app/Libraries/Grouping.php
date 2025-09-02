<?php
 
namespace App\Libraries;
 
class Grouping {
 
    public function byDecade(array $sezony): array
    {
        $poDekadach = [];
 
        foreach ($sezony as $s) {
            $dekada = floor($s->start / 10) * 10; // např. 1991 -> 1990
            $poDekadach[$dekada][] = $s;
        }
 
        ksort($poDekadach);
        return $poDekadach;
    }
}