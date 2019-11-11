<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/6/19
 * Time: 2:29 PM
 */

namespace App\Repositories\Localization;


interface LocalizationRepositoryInterface
{

    public function all();
    public function create(array $arr);
    public function find($id);
    public function destroy($id);
    public function update(array $arr, $id);
    public function findByCountryId($country_id);
    public function findByName($name);

}