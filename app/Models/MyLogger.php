<?php

namespace App\Models;

class MyLogger
{

    public function log($message)
    {

        try {
            $file = fopen("log.txt", "a");
            fwrite($file, $message."\r\n");
            fclose($file);
        }catch (\Exception $exception){
            return false;
        }

         return true;

    }

}
