<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/23/19
 * Time: 3:19 PM
 */

namespace App\Traits;

use App\Accounting\Models\AccountHolder;
use Illuminate\Database\Eloquent\Relations\HasOne;


trait AccountHolderTrait
{

    protected $id_column = 'id';


    /**
     *
     */
    public static function bootAccountableTrait()
    {
        static::created(function($model) {
            AccountHolder::getOrCreate($model);
        });
    }

    public function getAccountId()
    {
        return $this->{$this->id_column};
    }

    public function getAccountType()
    {
        return $this->account_type;
    }

    /**
     * @return HasOne
     */
    public function account()
    {
        return $this->hasOne(AccountHolder::class, 'owner_id', $this->id_column)
            ->where('owner_type', $this->getAccountType());
    }

    /**
     * @return AccountHolder
     */
    public function getAccount()
    {
        return $this->account ? : new AccountHolder();
    }

    /**
     * @param $type
     * @param $amount
     * @param $document_ref
     * @param $notes
     * @return bool
     */
    public function credit($type, $amount, $document_ref, $notes)
    {
        return AccountHolder::credit($this->id, $this->getAccountType(), $type, $amount, $document_ref, $notes);
    }

    /**
     * @param $type
     * @param $amount
     * @param $document_ref
     * @param $notes
     * @return mixed
     */
    public function debit($type, $amount, $document_ref, $notes)
    {
        return AccountHolder::debit($this->id, $this->getAccountType(), $type, $amount, $document_ref, $notes);
    }

}