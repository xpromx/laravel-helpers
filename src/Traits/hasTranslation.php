<?php 

namespace Travelience\Helpers\Traits;

use LaravelLocalization;

trait hasTranslation {

	/*
	protected $casts = [
						    'translations' => 'array',
							];
	*/

	/**
     * Get the translation for the specified field
     *
     * @param String $field
     * @param String $target
     * @param String $source
     * @return \Illuminate\Http\Response
     */
	public function trans( $field, $target=false, $source='en' )
	{

		// check for field
		if( !$this->$field ){ return false; }

		// check for language
		if( is_route_path('admin.') )
		{
			return $this->transExists( $field, $target );
		}

		if( !$target )
		{ 
			$target = app()->getLocale(); 
		}

		// check if is already translated
		if( $r = $this->transExists( $field, $target ) )
    {
      return $r;
    }
		

		// return orignial
		return $this->$field;


		/*
		$r = $this->translateProvider( $this->$field, $target, $source );

		return $r;
		*/

	}

	/**
     * Check if the requested translation exists
     *
     * @param String $field
     * @param String $target
     * @return \Illuminate\Http\Response
     */
	public function transExists( $field, $target )
	{
		if( isset($this->translations[$target][$field]) )
		{
			return $this->translations[$target][$field];
		}

		return false;
	}

}

?>