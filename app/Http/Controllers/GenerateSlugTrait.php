<?php

namespace App\Http\Controllers;

trait GenerateSlugTrait
{
    protected function generateSlug($numb)
    {
        return dechex(time()).dechex($numb);
    }
}
