<?php 

namespace Travelience\Helpers;

use Auth;
use Str;
use Validator;

abstract class Repository {


    public    $model;
    public    $export = ['id','updated_at','created_at'];
    public    $meta_sync = true;


    /**
    * Construct of the Repository
    *
    * @return void
    */
    public function __construct()
    {
       $this->model =  app()->make( $this->model );
    }

    /**
    * Get model by ID
    *
    * @param Integer $id
    * @return Collection
    */
    public function getById($id)
  	{
  		 return $this->model->findOrFail($id);
  	}


    /**
    * Get all register of this Model
    *
    * @return Collection
    */
    public function all()
    {
        return $this->model->all();
    }


    /**
    * Update the information of this model
    *
    * @param Array $data
    * @param Integer $id
    * @return Collection
    */
    public function update( array $data, $id )
    {

       $this->model = $this->model->find($id);

       if( isset($data['slug']) )
       {
          $data['slug'] = Str::slug( $data['slug'] );
       }

       if( isset($data['meta']) && $this->meta_sync )
       {
          $data['meta'] = $this->syncMeta( $data['meta'] );
       }
       
       $this->model->update( $data );

       $this->storage( $data );

       return $this->model;
    }


    /**
    * Create a new register of this Model
    *
    * @param Array $data
    * @return Collection
    */
    public function create( array $data )
    { 

       if( isset($data['slug']) )
       {
          $data['slug'] = Str::slug( $data['slug'] );
       }

       if( isset($data['title']) )
       {
           $data['slug'] = Str::slug( $data['title'] );
       }

       if( isset($data['meta']) )
       {
          $data['meta'] = $this->syncMeta( $data['meta'] );
       }

       $this->model = $this->model->create( $data );

       $this->storage( $data );

       return $this->model;
    }


    /**
    * Delete the register of this model
    *
    * @param Integer $id
    * @return Collection
    */
    public function delete( $id )
  	{
  		 return $this->model->find($id)->delete();
  	}

    
    /**
    * Check if the model exists with the given information
    *
    * @param String $field
    * @param String $value
    * @return Collection
    */
    public function exists( $field, $value )
    {
        $validator = Validator::make(
            [$field => $value],
            [$field => 'exists:'. $this->model->getTable() .','. $field ]
        );

        if (!$validator->fails())
        {
             return $this->model->where($field,'=',$value)->first();
        }

        return false;
    }

    /**
    * Sync meta information in this Model
    *
    * @param Array $data
    * @param String $field
    * @return Array
    */
    public function syncMeta( $data, $field='meta' )
    {
        if( !$data || count($data) == 0 ){ return false; }

        $meta = [];

        if( $this->model->$field )
        {
            $meta = $this->model->$field;
        }

        $data = array_merge($meta, $data);

        return $data;
    }

    /**
    * Sync meta information in this Model pushing new values
    *
    * @param Array $data
    * @param String $field
    * @return Array
    */
    public function syncMetaPush( $data, $field='meta' )
    {

        if( !$data || count($data) == 0 ){ return false; }

        $meta = [];

        if( $this->model->$field )
        {
            $meta = $this->model->$field;
        }
        
        foreach($data as $key=>$value)
        {      
            if( !isset($meta[$key]) || !in_array( $value, $meta[$key] ) )
            { 
                $meta[$key][] = $value;
            }
            
        }

        return $meta;
        
    }

    
   /**
    * Save one to Many relations
    *
    * @param Array $data
    * @return Array
    */
    public function saveMany( $method, $foreignKey, $ids, $data=[], $delete=true )
    {
        if( $delete )
        {
            $this->model->$method()->delete();
        }

        foreach( $ids as $id )
        {
            $params = array_merge( $data, [$foreignKey => $id] );

            $this->model->$method()->create($params);
        }
        
    }

    /**
    * Sync one to Many relations
    *
    * @param Array $data
    * @return Array
    */
    public function syncMany( $method, $foreignKey, $ids, $data=[], $delete = true )
    {
        if( $delete )
        {
            $this->model->$method()->whereNotIn($foreignKey, $ids)->delete();
        }

        foreach( $ids as $id )
        {
            $params = array_merge( $data, [$foreignKey => $id] );

            // create if doesn't exist
            if( !$this->model->$method()->where($foreignKey, $id)->first() )
            {
                $this->model->$method()->create($params);
            }
            
        }
        
    }

    /**
    * Get Fillable attributes from model
    *
    * @return Array
    */
    public function getFillable()
    {
        $fields = $this->model->getFillable();
        $fields[] = 'token';

        return $fields;
    }

 
}