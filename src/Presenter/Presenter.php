<?php

namespace Travelience\Helpers;

use Exception;
use Carbon;
use Str;

abstract class Presenter
{
    /**
     * The authenticated user.
     *
     * @var User
     */
    protected $model;

    /**
     * Create a new Presenter instance.
     *
     * @param User $user
     */
    public function __construct($model)
    {
        // You could also remain this to
        // something more generic, like $model.
        $this->model = $model;
    }

    /**
     * Handle dynamic property calls.
     *
     * @param  string $property
     * @return mixed
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }

        $message = '%s does not respond to the "%s" property or method.';

        throw new Exception(
            sprintf($message, static::class, $property)
        );
    }

    /**
     * Format created_at attribute
     *
     * @param Carbon  $date
     * @return string
     */
    public function created_at()
    {
      return $this->getDateFormated( $this->model->created_at );
    }

    /**
     * Format updated_at attribute
     *
     * @param Carbon  $date
     * @return string
     */
    public function updated_at()
    {
      return $this->getDateFormated( $this->model->updated_at );
    }

    /**
     * Format updated_at attribute for sitemap date format
     *
     * @param Carbon  $date
     * @return string
     */
    public function updated_at_for_sitemap()
    {
        return Carbon::parse( $this->model->updated_at )->format('Y-m-d');
    }

    /**
     * Format date
     *
     * @param Carbon  $date
     * @return string
     */
    private function getDateFormated($date)
    {
      return Carbon::parse($date)->format(config('app.locale') == 'ja' ? 'Y-m-d' : 'm-d-Y');
    }

    /**
     * Format updated date for humans
     *
     * @return String
     */
    public function updated_at_for_humans()
    { 
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->model->updated_at)->diffForHumans();
    }

    /**
     * Formated created date for humans
     *
     * @return String
     */
    public function created_at_for_humans()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->model->created_at)->diffForHumans();
    }

    /**
     * get a truncated description
     *
     * @return String
     */
    public function description()
    {
        return Str::limit( trim( strip_tags($this->model->content) ) , 100);
    }


    /**
     * Get the next item to show
     *
     * @return Collection
     */
    public function next()
    {
        return $this->model->where('id','>', $this->model->id)->first();
    }

    /**
     * Get the previous item to show
     *
     * @return Collection
     */
    public function back()
    {
        return $this->model->where('id','<', $this->model->id)->first();
    }


    /**
     * Return the simplified version of this model in array
     *
     * @return Array
     */
    public function toArray()
    {

        return [
                'id'          => $this->model->id,
                'type'        => $this->model->getTable(),
                'created_at'  => $this->model->present()->created_at_for_humans,
              ];

    }

    /**
     * Return the url for this model
     *
     * @return Array
     */
    public function url( $path='index' )
    {
        $model = str_singular( $this->model->getTable() );

        return route( $model. '.' . $path, [$model => $this->model->id]);
    }

    

}