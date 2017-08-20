<?php

namespace Travelience\Helpers\Storage;
use App;
use Spatie\MediaLibrary\UrlGenerator\BaseUrlGenerator;
use Spatie\MediaLibrary\UrlGenerator\UrlGenerator;

class StorageUrl extends BaseUrlGenerator implements UrlGenerator
{
    /**
     * Get the url for the profile of a media item.
     *
     * @return string
     */
    public function getUrl()
    {

      if( !$domain = config('laravel-medialibrary.s3.domain') )
      {
          $domain  = config('app.url');
      }

      return $domain.$this->getPathRelativeToRoot();

    }
}

?>
