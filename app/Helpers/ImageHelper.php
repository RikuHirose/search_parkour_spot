<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ImageHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Helpers\ImageHelperInterface::class;
    }
}
