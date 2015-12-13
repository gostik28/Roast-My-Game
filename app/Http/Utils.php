<?php

namespace App\Http;

use Image;
use App\Game;
use Illuminate\Support\Str;

class Utils
{
    public static function get_image_url($fileName)
    {
        return '/upload/'.$fileName;
    }

    public static function preg_grep_keys($pattern, $input, $flags = 0)
    {
        return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
    }

    public static function upload_image($requestImage, $uploadName)
    {

        if($requestImage->getMimeType() == 'image/gif') {
            $saveFileName = Utils::get_valid_upload_name($uploadName, '.gif');
            copy($requestImage->getRealPath(), Game::getBackupImageUploadPath() . $saveFileName);
        }

        else {
            $saveFileName = Utils::get_valid_upload_name($uploadName, '.jpg');
            Image::make($requestImage)
                ->encode('jpg')
                ->heighten(600, function ($constraint) {
                    $constraint->upsize();
                })
                ->save(Game::getBackupImageUploadPath() . $saveFileName, 85);
        }
//        $s3->putObject(array(
//            'ACL'        => 'public-read',
//            'Bucket'     => 'topicloop-upload2',
//            'CacheControl' => 'max-age=1814400',
//            'Key'        => Post::getImageUploadPath().$imageUploadedName,
//            'SourceFile' => Post::getBackupImageUploadPath().$imageUploadedName,
//        ));

        return $saveFileName;
    }


    private static function get_valid_upload_name($requested_name, $extension)
    {
        return $requested_name.$extension; //this should be enough to get a unique name since we always get a unique slug
    }

    public static function generate_unique_slug($title)
    {
        //and here you put all your logic that solve the problem
        $potentialSlug = Str::slug(substr($title, 0, 33));
        if(Game::where('slug', $potentialSlug)->count() >= 1){
            $i = 1;
            $newslug = $potentialSlug . '-' . $i;
            while(Game::where('slug',$newslug)->count() >= 1){
                $i++;
                $newslug = $potentialSlug . '-' . $i;
            }
            $potentialSlug = $newslug;
        }
        return $potentialSlug;
    }



}
