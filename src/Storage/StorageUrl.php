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
    public function getUrl() : string
    {
        
      if( !$domain = config('laravel-medialibrary.s3.domain') )
      {
          $domain  = config('app.url');
      }

      return $domain . $this->getBaseMediaDirectory() . '/' . $this->getPathRelativeToRoot();

    }

    /*
     * Get the path where the whole medialibrary is stored.
     */
    protected function getStoragePath() : string
    {
        return $this->config->get("filesystems.disks.{$this->media->disk}.root");
    }

    /*
     * Get the directory where all files of the media item are stored.
     */
    protected function getBaseMediaDirectory(): string
    {
        return str_replace(public_path(), '', $this->getStoragePath());
    }


}

?>
