<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/22/18
 * Time: 11:27 PM
 */

namespace App\Repositories\Conversation;


interface ConversationRepositoryInterface
{

    public function store(array $arr);
    public function find($id);
    public function destroy($id);
    public function all();
    public function getByGroupId($group_id);

}
