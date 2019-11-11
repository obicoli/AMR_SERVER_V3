<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 2/15/19
 * Time: 4:47 PM
 */

namespace App\Repositories\Practice;


use App\Models\Practice\Practice;
use App\Models\Practice\PracticeAsset;

class PracticeAssetRepository implements PracticeAssetRepositoryInterface
{

    protected $practiceAsset;

    public function __construct(PracticeAsset $practiceAsset)
    {
        $this->practiceAsset = $practiceAsset;
    }

    public function create(PracticeAsset $practiceAsset, Practice $practice)
    {
        // TODO: Implement create() method.
        //return $practice->assets()->save($practiceAsset);
    }


}
