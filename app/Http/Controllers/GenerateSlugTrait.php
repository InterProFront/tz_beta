<?php

namespace App\Http\Controllers;

trait GenerateSlugTrait
{
    protected function generateSlug($numb)
    {
        return dechex(time() + 500000000 * random_int(1,10) + $numb);
    }
}
