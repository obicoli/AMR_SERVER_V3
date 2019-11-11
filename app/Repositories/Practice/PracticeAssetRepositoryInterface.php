<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 2/15/19
 * Time: 4:48 PM
 */

namespace App\Repositories\Practice;


use App\Models\Practice\Practice;
use App\Models\Practice\PracticeAsset;

interface PracticeAssetRepositoryInterface
{

    public function create(PracticeAsset $practiceAsset, Practice $practice);

}
