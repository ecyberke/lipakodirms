<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test()
    {
        $myfile = fopen('funcname' . time() . '.json', "w") or die("Unable to open file!");
        $txt = "John Doe\n";
        fwrite($myfile, $txt);
        fclose($myfile);

        return response('ola');
    }
}
