<?php

namespace Travelience\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilters
{
	/**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The builder instance.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Create a new QueryFilters instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters to the builder.
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder, $default=[])
    {
        $this->builder = $builder;
        
        $filters = array_merge( $default, $this->filters() );
        
        foreach ($filters as $name => $value) 
        {

            if ( method_exists($this, $name)) 
            {
            	if( isset($value) )
            	{
            		call_user_func_array([$this, $name], array_filter([$value]) );
            	}
            }
            
        }

        // default
        $this->builder = $this->defaultFilter();

        return $this->builder;
    }

    /**
     * Get all request filters data.
     *
     * @return array
     */
    public function filters()
    {
        return $this->request->all();
    }

    /* DEFAULT FILTERS */

    /**
     * Filter by status name
     *
     * @param String $value
     * @return Builder
     */
    public function status( $value=false )
    {
        if( !$value ){ return $this->builder; }
        
        return $this->builder->where('status','=', $value);
    }

    /**
     * Exclude Ids from search
     *
     * @param Array $ids
     * @return Builder
     */
    public function notIn( $ids )
    {
        return $this->builder->whereNotIn('id', $ids);
    }

    /**
     * Return only specified Ids
     *
     * @param Array $ids
     * @return Builder
     */
    public function In( $ids )
    {
        return $this->builder->whereIn('id', $ids);
    }

    /**
     * Filter by language
     *
     * @param String $value
     * @return Builder
     */
    public function lang( $value )
    {
        return $this->builder->where('language_id','=', $value);
    }

    /**
     * Filter by created date >=
     *
     * @param String $value
     * @return Builder
     */
    public function created( $value )
    {
        return $this->builder->where('created_at','>=', $value);
    }

    /**
     * Filter by updated date >=
     *
     * @param String $value
     * @return Builder
     */
    public function updated( $value )
    {
        return $this->builder->where('updated_at','>=', $value);
    }

    /**
     * Sort result by params
     *
     * @param String $value
     * @return Builder
     */
    public function sort( $value )
    {
        $value = explode(':', $value);
        $field = $value[0];
        $sort  = ( isset($value[1]) ? $value[1] : 'desc' );

        $table = $this->getTable().'.';

        if( Str::contains( $field, '#' ) )
        {
            $table = '';
            $field = str_replace('#','', $field);
        }

        return $this->builder->orderBy( $table . $field, $sort );
    }

    /**
     * Filter by parent id
     *
     * @param Integer $value
     * @return Builder
     */
    public function parent( $value=0 )
    {
        return $this->builder->where('parent_id','=', $value);
    }

    /**
     * Default Filters that will be applied all the time
     *
     * @return Builder
     */
    public function defaultFilter()
    {
        return $this->builder;
    }


    /**
     * Limit the results
     *
     * @return Builder
     */
    public function limit( $value=false )
    {
        if( !$value ){ return $this->builder; }

        return $this->builder->limit( $value );
    }

}