<?php

namespace Travelience\Helpers\Storage;

use Request;
use Validator;
use Spatie\MediaLibrary\Media;


class Storage
{

    protected $model;
   

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Attach a file or array of files to the model
     *
     * @param String/Array $field
     * @param String $collection
     * @return Collection
     */
    public function attach( $files, $collection='default' )
    {


        if( $files )
        {
             if( !is_array($files) )
             {
                return $this->attachSingle( $files, $collection );
             }

             return $this->attachMultiple( $files, $collection );
        }


        return false;
    }

    /**
     * Get the file name formated for URL
     *
     * @param String $name
     * @return String
     */
    public function getFileName( $name )
    {

        if( strpos($name, '/') !== false )
        {
            $name = explode('/', $name);
            $name = last($name);
        }

        $ext = explode('.', $name);
        $ext = last($ext);

        $name = str_replace('.'.$ext, '', $name);

        $name = str_slug($name);

        if( strlen($name) == 0 )
        {
            $name = 'media-' . rand(1000,9999);
        }

        return  $name.'.' . $ext;
    }

    /**
     * Attach a Single File
     *
     * @param File $file
     * @param String $collection
     * @return Boolean
     */
    public function attachSingle( $file, $collection )
    {

        $name = $this->getFileName( $file->getClientOriginalName() );

        // validate file
        $validator = Validator::make(['photo' => $file], [
            'photo' => 'required|mimes:jpeg,bmp,png,gif',
        ]);

        if( $validator->fails() )
        {
            alert( 'Picture format invalid, only : jpeg,bmp,png,gif ', 'danger' );
            return false;
        }


        $this->model->clearMediaCollection( $collection );
        $this->model->addMedia( $file )->usingFileName( $name )->toMediaLibrary( $collection );  
        
        return true;
    }

    /**
     * Attach file from URL
     *
     * @param String $url
     * @param String $collection
     * @return Collection
     */
    public function attachFromUrl( $url, $collection='default' )
    {

        if( $collection=='default' )
        {
            $this->model->clearMediaCollection($collection);    
        }

        $name = $this->getFileName( $url );
        return $this->model->addMediaFromUrl( $url )->usingFileName( $name )->toMediaLibrary( $collection );  
        
    }

    /**
     * Attach Multiple Files
     *
     * @param Array $files
     * @param String $collection
     * @return Boolean
     */
    public function attachMultiple( $files, $collection )
    {

        foreach( $files as $file )
        {
            if( $file )
            {
                $name = $this->getFileName( $file->getClientOriginalName() );

                $this->model->addMedia( $file )->usingFileName( $name )->toMediaLibrary( $collection );      
            }   
        }

        return true;
    }

    /**
     * Check if we have at least one file in the collection and return it
     *
     * @param String $collection
     * @return Media
     */
    public function hasFile( $collection='photo' )
    {

        $status = ['active'];

        if( is_route_path('admin') )
        {
            $status = ['active','inactive'];
        }

        if( $file = $this->model->getMedia( $collection )->whereIn('status',$status)->first() )
        {
            return $file;
        }

        return false;
    }

    /**
     * Get the first file from the selected collection
     *
     * @param String $collection
     * @return Media
     */
    public function getFile( $collection='photo' )
    {
        return $this->hasFile( $collection );
    }

    /**
     * Get all the files in the collection realted to this Model
     *
     * @param String $collection
     * @return Collection
     */
    public function collection( $collection='photos' )
    {
        $status = ['active'];

        if( is_route_path('admin') )
        {
            $status = ['active','inactive'];
        }

        return $this->model->getMedia( $collection )->whereIn('status',$status);
    }
    
}