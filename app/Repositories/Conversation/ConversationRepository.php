<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/22/18
 * Time: 11:27 PM
 */

namespace App\Repositories\Conversation;


use App\Models\Conversation\Conversation;

class ConversationRepository implements ConversationRepositoryInterface
{
    protected $conversation;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    public function store(array $arr)
    {
        // TODO: Implement store() method.
        return $this->conversation->create($arr);
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function getByGroupId($group_id)
    {
        // TODO: Implement getByGroupId() method.
        return $this->conversation->all()->where('group_id',$group_id);
    }


}
