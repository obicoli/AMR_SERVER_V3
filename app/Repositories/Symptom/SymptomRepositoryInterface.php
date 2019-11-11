<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/17/18
 * Time: 1:16 AM
 */

namespace App\Repositories\Symptom;


use App\Models\Symptom\SymptomCategory;

interface SymptomRepositoryInterface
{

    public function all();
    public function find($id);
    public function store(array $arr);
    public function destroy($id);
    public function update(array $arr, $id);
    public function get_category_symptoms(SymptomCategory $symptomCategory);

    public function transform_collection($collections);
    public function transform_category_collection($collections);
    public function transform_symptom_collection($collections);
}
