<?php
	
	namespace Travelience\Helpers\Storage;

	trait StorageConversions
	{

		public function registerMediaConversions()
	  {

	    	foreach( config('medialibrary.conversions') as $key => $sizes )
	    	{
	    		$this->addMediaConversion( $key )
	             	 ->setManipulations( $sizes )
	             	 ->performOnCollections( 'photo', 'gallery' )
	             	 ->nonQueued();
	    	}
	        
	  }

	}