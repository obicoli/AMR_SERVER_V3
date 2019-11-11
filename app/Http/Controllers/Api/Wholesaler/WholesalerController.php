<?php

namespace App\Http\Controllers\Api\Wholesaler;

use App\Models\Wholesaler\Wholesaler;
use App\Repositories\Wholesaler\WholesalerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WholesalerController extends Controller
{
    protected $wholesaler;

    public function __construct(Wholesaler $wholesaler)
    {
        $this->wholesaler = new WholesalerRepository($wholesaler);
    }

}
