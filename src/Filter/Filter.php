<?php

namespace Travelience\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Travelience\Helpers\QueryFilters;

trait Filter
{
    /**
     * Filter a result set.
     *
     * @param  Builder      $query

     * @param  QueryFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, QueryFilters $filters, $default=[])
    {        
        return $filters->apply($query, $default);
    }


    /**
     * Filter a result set.
     *
     * @param  Builder      $query
     * @param  QueryFilters $filters
     * @return Builder
     */
    public function scopeSearch($query, $default=[])
    {        

        $class = __CLASS__ . 'Filters';
        $class = str_replace('Models', 'Filters', $class);

        $filters = new $class( request() );

        return $filters->apply($query, $default);
    }

}
