<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use Response;
    public function index(){
        /// response de el status code zay error 404 w error 200 The 200 OK status code means that the request was successful, but the meaning of success depends on the request method used

        return $this->ResponseAPI('data' , 200 , 'your data');
    }

}
