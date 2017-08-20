<?php

namespace Travelience\Helpers\Storage;

use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class StoragePath implements PathGenerator
{
    /**
     * Get the path for the given media, relative to the root storage path.
     *
     * @param \Spatie\MediaLibrary\Media $media
     *
     * @return string
     */
    public function getPath(Media $media) : string
    {
        return $this->getFolder( $media ) . '/';
    }

    /**
     * Get the path for conversions of the given media, relative to the root storage path.
     *
     * @param \Spatie\MediaLibrary\Media $media
     *
     * @return string
     */
    public function getPathForConversions(Media $media) : string
    {
        return $this->getFolder( $media ). '/th/';
    }

    /**
     * Get the folder name to storage the file
     *
     * @param \Spatie\MediaLibrary\Media $media
     *
     * @return string
     */
    public function getFolder( Media $media ) : string
    {
        $year   = date("Y", strtotime($media->created_at));
        $month  = date("m", strtotime($media->created_at));

        return $year . '/' . $month . '/' . $media->id;
    }
    

}