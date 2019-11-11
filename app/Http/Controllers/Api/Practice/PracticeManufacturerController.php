<?php

namespace App\Http\Controllers\Api\Practice;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class PracticeManufacturerController extends Controller
{
    protected $practice;
    protected $response_type;
    protected $helper;

    public function __construct(Practice $practice)
    {
        $this->practice = new PracticeRepository($practice);
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }
}
