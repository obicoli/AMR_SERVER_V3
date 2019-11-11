<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/23/19
 * Time: 3:19 PM
 */

namespace App\Traits;

use App\Models\Account\COA\AccountsCoa;
use Illuminate\Database\Eloquent\Relations\HasOne;


trait CoaTrait
{

    protected $id_column = 'id';


    /**
     *
     */
    public static function bootCoaTrait()
    {
        static::created(function($model) {
            AccountsCoa::getOrCreate($model);
        });
    }

    // public function getAccountId()
    // {
    //     return $this->{$this->id_column};
    // }

    // public function getAccountType()
    // {
    //     return $this->account_type;
    // }

    // /**
    //  * @return HasOne
    //  */
    // public function account()
    // {
    //     return $this->hasOne(Account::class, 'owner_id', $this->id_column)
    //         ->where('owner_type', $this->getAccountType());
    // }

    // /**
    //  * @return Account
    //  */
    // public function getAccount()
    // {
    //     return $this->account ? : new Account();
    // }

    // /**
    //  * @param $type
    //  * @param $amount
    //  * @param $document_ref
    //  * @param $notes
    //  * @return bool
    //  */
    // public function credit($type, $amount, $document_ref, $notes)
    // {
    //     //return Account::credit($this->id, $this->getAccountType(), $type, $amount, $document_ref, $notes);
    // }

    // /**
    //  * @param $type
    //  * @param $amount
    //  * @param $document_ref
    //  * @param $notes
    //  * @return mixed
    //  */
    // public function debit($type, $amount, $document_ref, $notes)
    // {
    //     //return Account::debit($this->id, $this->getAccountType(), $type, $amount, $document_ref, $notes);
    // }

}
