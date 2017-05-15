<?php

namespace App;

class Addons
{

    public static function getMediaSpaceFree()
    {
        $mediaroot = env('MEDIA_UPLOAD_PATH');
        if (file_exists($mediaroot)) {
            return disk_free_space($mediaroot) / 1024;
        } else {
            return false;
        }
    }

    public static function removeMediaFile($fullpath)
    {
        if (file_exists($fullpath)) {
            try {
                unlink($fullpath);
                return true;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            return false;
        }
    }

}