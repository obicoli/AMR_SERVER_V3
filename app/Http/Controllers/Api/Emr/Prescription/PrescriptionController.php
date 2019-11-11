<?php

namespace App\Http\Controllers\Api\Records\Prescription;

use App\Models\Records\Prescription\PrescriptAsset;
use App\Models\Records\Prescription\Prescription;
use App\Repositories\Emr\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrescriptionController extends Controller
{
    protected $prescription;
    protected $prescriptionAssets;

    public function __construct()
    {
        $this->prescription = new PrescriptionRepository(new Prescription());
        $this->prescriptionAssets = new PrescriptionRepository(new PrescriptAsset());
    }

    public function index(){}
    public function create(Request $request){}
    public function update(Request $request, $uuid){}
    public function show($uuid){}
    public function delete($uuid){}

}
