<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Image;

/*require_once("conekta-php-master/lib/Conekta.php");
\Conekta\Conekta::setApiKey("key_rKc4BNk2zVQ44qYxntA7YQ");
\Conekta\Conekta::setApiVersion("2.0.0");*/

trait GeneralFunctions
{
	/**
     * Verify if a file is valid, then upload it to a given path.
     *
     * @return $name
     */
    public function upload_file($file, $path, $rename = false, $resize = false)
    {
        $extensions = array("1"=>"jpeg", "2"=>"jpg", "3"=>"png", "4"=>"gif");
        $name = '';

        if ($file) {
            $file_ext = $file->getClientOriginalExtension();
            if (array_search($file_ext, $extensions)) {
                if (!File::exists($path)) {
                    File::makeDirectory(public_path().'/'.$path, 0755, true, true);
                }

                $name  = $rename ? $path.'/'.time().'.'.$file_ext : $path.'/'.$file->getClientOriginalName();

                $name = $path.'/'.time().'.'.$file_ext;

                if ($resize) {
                    $content = Image::make($file)
                    ->resize($resize['width'], $resize['height'])
                    ->save($name);
                } else {
                    $file->move($path, $name);
                }
                
                return $name;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Send a notification to a single user or a group of users.
     *
     * @return $name
     */
    public function send_notification()
    {
    }
}
