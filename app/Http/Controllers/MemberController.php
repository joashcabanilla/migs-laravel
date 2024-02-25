<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Model
use App\Models\VotersModel;

//Class
use App\Classes\HelperClass;

class MemberController extends Controller
{
    protected $data, $helper, $votersModel;

    public function __construct()
    {
        $this->middleware('admin');
        $this->votersModel = new VotersModel();
        $this->helper = new HelperClass();
        $this->data = array();
    }

    
}
