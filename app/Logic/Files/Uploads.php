<?php

namespace App\Logic\Files;

use App\Models\Records\Prescription\Prescription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Uploads
{
    public function store_upload(Request $request, Model $model, $upload_type = false){

        $results = [];
        $path_to_store = "";

        if ($upload_type){

            switch ($upload_type){
                case 'Prescription':
                    $path_to_store = $_SERVER['DOCUMENT_ROOT'].Prescription::UPLOAD_PATH.$model->id;
                    break;
            }

            if (!$this->is_file_exist($path_to_store)){
                if ($this->create_directory($path_to_store)){
                    return $results;
                }
            }

            $date_ = date('Y-m-d H:i:s');
            $date_ = str_replace(" ","",$date_);
            $date_ = str_replace("-","",$date_);
            $file_path = $path_to_store.'/'.$date_.'_'.$model->id;
            $files = $request->file('files');
            if ($files[0] != ''){
                $storagePath = Storage::disk('local')->put($file_path, $files);
                $results = $request->all();
                $results['file_path'] = $file_path;
                $results['file_mime'] = $_FILES['files']['type'];
                $results['file_name'] = $_FILES['files']['name'];
                $results['file_size'] = $_FILES['files']['size'];
            }

        }
        return $results;
    }

//    private function upload_prescription(Request $request, Prescription $prescription)
//    {
//        $results = false;
//        $path_to_store = $_SERVER['DOCUMENT_ROOT'].Prescription::UPLOAD_PATH.$prescription->id;
//        if (!$this->is_file_exist($path_to_store)){
//            if ($this->create_directory($path_to_store)){
//                return $results;
//            }
//        }
//        $date_ = date('Y-m-d H:i:s');
//        $date_ = str_replace(" ","",$date_);
//        $date_ = str_replace("-","",$date_);
//        $file_path = $path_to_store.'/'.$date_.'_'.$prescription->id;
//        $files = $request->file('files');
//        if ($files[0] != ''){
//            $storagePath = Storage::disk('local')->put($file_path, $files);
//            $asset = $request->all();
//            $asset['file_path'] = $file_path;
//            $asset['file_mime'] = $_FILES['clinic_logo']['type'];
//            $asset['file_name'] = $_FILES['clinic_logo']['name'];
//            $asset['file_size'] = $_FILES['clinic_logo']['size'];
//        }
//
//    }

    protected function is_file_exist($file_name){

        if ( file_exists( $file_name ) ){
            return true;
        }
        return false;
    }

    protected function create_directory($directory){

        if ( file_exists( $directory ) ){
            return true;
        }
        mkdir($directory, 0777, true);
        return false;

    }

}
