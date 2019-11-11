<?php

namespace App\Models\Account;

use App\Traits\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    use UuidTrait, SoftDeletes;

    const AC_SUSPENSE = "SUSPENSE";
    const AC_USER = "USER";
    const AC_HOSPITAL = "HOSPITAL";
    const AC_PRACTICE = "PRACTICE";
    const AC_PHARMACY = "PHARMACY";
    const AC_DOCTOR = "DOCTOR";
    const AC_PATIENT = "PATIENT";
    const AC_MANUFACTURES = "MANUFACTURERS";
    const AC_SUPPLIERS = "SUPPLIERS";
    const AC_WHOLESALERS = "WHOLESALERS";
    const AC_CUSTOMERS = "CUSTOMERS";

    const SYSTEM_ACCOUNT_NAME = "TRANSACTION FEES ACCOUNT";
    const GENERAL_SUSPENSE_ACCOUNT = "GENERAL SUSPENSE ACCOUNT";
    const WITHDRAWAL_SUSPENSE_ACCOUNT = "WITHDRAWAL SUSPENSE ACCOUNT";

    protected $table = "accounts";

    public $update_balance = false;

    protected $fillable = [
        "owner_id", "owner_type", "name", "bonus", "main", "balance"
    ];

    public static $suspense_account_id = 1;

    public static function getOrCreate($accountable)
    {
        $ac = Account::whereOwnerId($accountable->getAccountId())
            ->whereOwnerType($accountable->getAccountType())
            ->first();

        if (!$ac) {
            $ac = new Account([
                "owner_id" => $accountable->getAccountId(),
                "owner_type" => $accountable->getAccountType(),
                "name" => $accountable->getAccountName(),
            ]);

            $ac->save();
        }

        return $ac;
    }

    public static function get_withdrawal_suspense_account()
    {
        return self::query()->where([
            "name" => "WITHDRAWAL SUSPENSE ACCOUNT",
            "owner_type" => "SUSPENSE"
        ]);
    }

    public static function get_from($owner_id, $owner_type)
    {
        return Account::query()->where([
            "owner_id" => $owner_id,
            "owner_type" => $owner_type
        ])->firstOrFail();
    }

    public function getBalance()
    {
        return $this->balance;
    }

    // public function ledgers()
    // {
    //     return $this->belongsTo(Ledger::class, "account_id", "id");
    // }

    /**
     * @param $owner_id
     * @param $owner_type
     * @param $account_type
     * @param $amount
     * @param $document_ref
     * @param $notes
     * @return bool
     */
    public static function credit($owner_id, $owner_type, $account_type, $amount, $document_ref, $notes) : bool
    {
        $result = false;

        DB::transaction(function () use ($owner_id, $owner_type, $account_type, $amount, $document_ref, $notes) {
            // Get account and credit it with the amount
            $account = self::get_from($owner_id, $owner_type);
            $account->{$account_type} += $amount;
            $account->update_balance();
            $account->save();

            //debit should always be zero
            $debit = 0;

            //Insert the transaction Ledger Entry
            DB::table("ledgers")->insert([
                "txn_date" => Carbon::now()->format('YmdHis'),
                "account_id" => $account->id,
                "credit" => $amount,
                "debit" => $debit,
                "balance" => $account->balance + $amount,
                "notes" => $notes,
                "ref" => $document_ref,
                "type" => $account_type,
                "created_at" => Carbon::now()
            ]);
        }, 5);

        return $result;
    }

    /**
     * @param $owner_id
     * @param $owner_type
     * @param $account_type
     * @param $amount
     * @param $document_ref
     * @param $notes
     * @return bool
     */
    public static function debit($owner_id, $owner_type, $account_type, $amount, $document_ref, $notes) : bool
    {
        $result = false;

        DB::transaction(function () use ($owner_id,$account_type, $owner_type, $document_ref, $amount, $notes, &$result) {
            /* Get account and credit with the amount */
            $account = self::get_from($owner_id, $owner_type);
            $account->{$account_type} -= $amount;
            $account->update_balance();
            $account->save();

            /* Insert ledger entry */
            DB::table("ledgers")->insert([
                "txn_date" => Carbon::now()->format('YmdHis'),
                "account_id" => $account->id,
                "credit" => 0,
                "debit" => $amount,
                "balance" => $account->balance - $amount,
                "notes" => $notes,
                'ref' => $document_ref,
                'type' => $account_type,
                'created_at' => Carbon::now()
            ]);

            $result = true;
        });

        return $result;
    }

    /**
     * @param $type
     * @param $owner_id
     * @param $owner_type
     * @param $account_type
     * @param $amount
     * @param $document_ref
     * @param $notes
     * @return bool
     */
    public static function transact($type, $owner_id, $owner_type, $account_type, $amount, $document_ref, $notes)
    {
        $success = false;
        switch ($type) {
            case 'credit':
                $success = Account::credit($owner_id, $owner_type,$account_type, $amount, $document_ref,  $notes);
                break;
            case 'debit':
                $success = Account::debit($owner_id, $owner_type,$account_type, $amount, $document_ref, $notes);
        }

        return $success;
    }

    /**
     * @param array $accounts
     * @param $amount
     * @param $document_ref
     * @param $notes
     */
    public static function transfer(array $accounts, $amount, $document_ref, $notes)
    {

        DB::transaction(function () use ($accounts, $amount, $notes, $document_ref) {
            $credit = $accounts['credit'];
            $debit = $accounts['debit'];
            self::debit($debit['owner_id'], $debit['owner_type'], array_get($debit, 'account_type', 'main'), $amount, $document_ref, $notes);
            self::credit($credit['owner_id'], $credit['owner_type'], array_get($credit, 'account_type', 'main'), $amount, $document_ref, $notes);
        });
    }

    public static function get_system_account()
    {
        return self::query()->where('name',self::SYSTEM_ACCOUNT_NAME)->firstOrFail();
    }


    public function update_balance()
    {
        if ($this->update_balance)
            $this->balance = ($this->main + $this->bonus);
    }
}
