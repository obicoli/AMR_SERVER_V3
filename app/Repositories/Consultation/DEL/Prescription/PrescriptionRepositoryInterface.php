<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/22/19
 * Time: 8:43 AM
 */

namespace App\Repositories\Consultation\Prescription;


interface PrescriptionRepositoryInterface
{
    public function all();
    public function findByUuid($uuid);
    public function destroy($uuid);
}
