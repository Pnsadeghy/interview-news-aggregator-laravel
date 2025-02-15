<?php

namespace App\Utils;

class QueryHelper
{
    public static function fullTextSearch($query, string $q, $columns)
    {
        return $query->whereAny($columns, 'like', "%{$q}%");

        #TODO check full text search problem

//        $fullTextSearch = self::getFullTextSearch($q);
//        if ($fullTextSearch === false) {
//             return $query->whereAny($columns, 'like', "%{$q}%");
//        }
//
//        $columns = implode(',', $columns);
//        return $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $fullTextSearch);
    }

    public static function getFullTextSearch(string $term): string|false
    {
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        if (count($words) > 4) return false;
        foreach ($words as $key => $word) {
            if (strlen($word) <= 3) return false;
            $words[$key] = '+*' . $word . '*';
        }

        return implode(' ', $words);
    }
}
