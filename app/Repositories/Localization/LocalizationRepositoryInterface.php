<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/6/19
 * Time: 2:29 PM
 */

namespace App\Repositories\Localization;

use App\Models\Localization\Country;

interface LocalizationRepositoryInterface
{

    public function all();
    public function create(array $arr);
    public function find($id);
    public function findByUuid($uuid);
    public function destroy($id);
    public function update(array $arr, $id);
    public function findByCountryId($country_id);
    public function findByName($name);
    public function transform_country(Country $country);

}