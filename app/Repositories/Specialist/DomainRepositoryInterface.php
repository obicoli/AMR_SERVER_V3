<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/16/18
 * Time: 8:03 PM
 */

namespace App\Repositories\Specialist;


interface DomainRepositoryInterface
{

    public function all();

    public function find($id);

    public function store(array $arr);

    public function destroy($id);

}
