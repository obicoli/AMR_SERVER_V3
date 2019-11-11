<?php

use App\Models\Practice\Department;
use Illuminate\Database\Seeder;
use \App\Models\Product\Product;
use \App\Models\Product\Disclaimer;
use \App\Models\Product\Precaution;
use \App\Models\Product\Dosage;
use \App\Models\Manufacturer\Manufacturer;
use \App\Models\Product\ProductType;
use \App\Models\Product\ProductUnit;
use \App\Models\Product\ProductBrand;
use \App\Models\Product\ProductBrandSector;
use \App\Models\Product\ProductCategory;
use \App\Models\Product\ProductGeneric;

// use App\Models\Product\Accounts\ProductAccountType;
// use App\Models\Product\Accounts\ProductAccountNature;
// use \App\Models\Practice\Practice;
// use \App\Models\Product\ProductPaymentMethod;

//use \App\Models\Product\ProductCurrency;
use \App\Models\Product\ProductBank;
use \App\Models\Product\ProductBankBranch;
use \App\Models\Product\ProductPracticeBank;

// use \App\Models\Product\Accounts\ProductAccountHolderType;
// use \App\Models\Product\Accounts\ProductAccountDetailType;

use App\Models\Account\COA\AccountsNature;
use App\Models\Account\COA\AccountsType;
use App\Models\Account\COA\AccountsCoa;

use App\Models\Account\Banks\AccountsBank;
use App\Models\Account\Banks\AccountsBankBranch;
use App\Models\Practice\Accounting\PracticeBank;
use App\Models\Hospital\Hospital;
use App\Models\Practice\Practice;
use App\Models\Inventory\ProductStock;
use App\Models\Account\Banks\AccountMasterBank;
use App\Models\Account\Banks\AccountMasterBankBranch;
use App\Models\Product\ProductFormulation;
use App\Models\Product\ProductReport;
use App\Models\Product\Vaccine\ProductVaccine;
use App\Models\Product\Profile\ProductProfile;
use App\Models\Product\Route\ProductRoutes;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // AccountsBank::create(['name'=>'KCB Limited']);
        // AccountsBankBranch::create(['branch_name'=>'Moi Avenue','branch_code'=>'017','bank_id'=>1]);
        // PracticeBank::create([
        //     'practice_id'=>1,
        //     'bank_id'=>1,
        //     'branch_id'=>1,
        //     'account_title'=>'AMREF UpperHill',
        //     'account_number'=>'0000000765',
        //     'accounts_type'=>'New account'
        // ]);
        // AccountMasterBank::create(['name'=>'KCB Limited']);
        // AccountMasterBankBranch::create(['name'=>'Moi Avenue','code'=>'017','bank_id'=>1]);
        
        // ProductAccountHolderType::create(['name'=>'Customer','slug'=>'customer']);
        // ProductAccountHolderType::create(['name'=>'Employee','slug'=>'employee']);
        // ProductAccountHolderType::create(['name'=>'Vendor','slug'=>'vendor']);
        // ProductAccountHolderType::create(['name'=>'Other','slug'=>'other']);

        // ProductAccountNature::create(['name'=>'Assets']);
        // ProductAccountNature::create(['name'=>'Liability']);
        // ProductAccountNature::create(['name'=>'Equity']);
        // ProductAccountNature::create(['name'=>'Expense']);
        // ProductAccountNature::create(['name'=>'Revenue']);

        // AccountsNature::create(['name'=>'Assets']);
        // AccountsNature::create(['name'=>'Liability']);
        // AccountsNature::create(['name'=>'Equity']);
        // AccountsNature::create(['name'=>'Expense']);
        // AccountsNature::create(['name'=>'Revenue']);

        // AccountsType::create(['name'=>'Current']);
        // AccountsType::create(['name'=>'Fixed']);

        // AccountsCoa::create(['name'=>'Salary','sys_default'=>true,'accounts_nature_id'=>4,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Cash','sys_default'=>true,'accounts_nature_id'=>4,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Inventory','sys_default'=>true,'accounts_nature_id'=>4,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Accounts Receivable(AR)','sys_default'=>true,'accounts_nature_id'=>4,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Accounts Payable(AP)','sys_default'=>true,'accounts_nature_id'=>2,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Telephone Expense','sys_default'=>true,'accounts_nature_id'=>4,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Capital','sys_default'=>true,'accounts_nature_id'=>3,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Land','sys_default'=>true,'accounts_nature_id'=>1,'accounts_type_id'=>2]);
        // AccountsCoa::create(['name'=>'Building','sys_default'=>true,'accounts_nature_id'=>1,'accounts_type_id'=>2]);
        // AccountsCoa::create(['name'=>'Notes payable','sys_default'=>true,'accounts_nature_id'=>2,'accounts_type_id'=>2]);
        // AccountsCoa::create(['name'=>'Tools and Equipments','sys_default'=>true,'accounts_nature_id'=>1,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Repair Service Revenue','sys_default'=>true,'accounts_nature_id'=>5,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Wages Expense','sys_default'=>true,'accounts_nature_id'=>4,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Utitlity Expense','sys_default'=>true,'accounts_nature_id'=>4,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Adverstising Expense','sys_default'=>true,'accounts_nature_id'=>4,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Cash in bank','sys_default'=>true,'accounts_nature_id'=>1,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Collection fee','sys_default'=>true,'accounts_nature_id'=>4,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Cost of goods','sys_default'=>true,'accounts_nature_id'=>4,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Sales','sys_default'=>true,'accounts_nature_id'=>5,'accounts_type_id'=>1]);
        // AccountsCoa::create(['name'=>'Tax payable','sys_default'=>true,'accounts_nature_id'=>2,'accounts_type_id'=>2]);
        
        // ProductAccountType::create(['name'=>'Accounts receivable(A/R)']);
        // ProductAccountType::create(['name'=>'Current assets']);
        // ProductAccountType::create(['name'=>'Cash and Cash Equivalent']);
        // ProductAccountType::create(['name'=>'Fixed assets']);
        // ProductAccountType::create(['name'=>'Non-current assets']);
        // ProductAccountType::create(['name'=>'Accounts payable(A/P)']);
        // ProductAccountType::create(['name'=>'Credit card']);
        // ProductAccountType::create(['name'=>'Current liability']);
        // ProductAccountType::create(['name'=>'Non-current liabilities']);
        // ProductAccountType::create(['name'=>"Owner's equity"]);
        // ProductAccountType::create(['name'=>"Income"]);
        // ProductAccountType::create(['name'=>"Other income"]);
        // ProductAccountType::create(['name'=>"Cost of sales"]);
        // ProductAccountType::create(['name'=>"Expenses"]);
        // ProductAccountType::create(['name'=>"Other expense"]);
        
        // //Product account type details
        // ProductAccountType::find(1)->detail_type()->save(ProductAccountDetailType::create(['name'=>"Accounts receivable(A/R)"]));
        // $prod_type2 = ProductAccountType::find(2);
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Allowance for bad debts"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Assets available for sale"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Development Costs"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Employee Cash Advances"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Inventory"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Investments - Other"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Loans To Officers"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Loans To Others"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Loans to Shareholders"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other current assets"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Prepaid Expenses"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Retainage"]));
        // $prod_type2->detail_type()->save(ProductAccountDetailType::create(['name'=>"Undeposited Funds"]));
        // $prod_type3 = ProductAccountType::find(3);
        // $prod_type3->detail_type()->save(ProductAccountDetailType::create(['name'=>"Bank"]));
        // $prod_type3->detail_type()->save(ProductAccountDetailType::create(['name'=>"Cash and cash equivalents"]));
        // $prod_type3->detail_type()->save(ProductAccountDetailType::create(['name'=>"Cash on hand"]));
        // $prod_type3->detail_type()->save(ProductAccountDetailType::create(['name'=>"Client trust account"]));
        // $prod_type3->detail_type()->save(ProductAccountDetailType::create(['name'=>"Money Market"]));
        // $prod_type3->detail_type()->save(ProductAccountDetailType::create(['name'=>"Rents Held in Trust"]));
        // $prod_type3->detail_type()->save(ProductAccountDetailType::create(['name'=>"Savings"]));
        // $prod_type4 = ProductAccountType::find(4);
        // $prod_type4->detail_type()->save(ProductAccountDetailType::create(['name'=>"Accumulated depletion"]));
        // $prod_type4->detail_type()->save(ProductAccountDetailType::create(['name'=>"Accumulated depreciation on property, plant and equipment"]));
        // $prod_type4->detail_type()->save(ProductAccountDetailType::create(['name'=>"Buildings"]));
        // $prod_type4->detail_type()->save(ProductAccountDetailType::create(['name'=>"Depletable Assets"]));
        // $prod_type4->detail_type()->save(ProductAccountDetailType::create(['name'=>"Furniture and Fixtures"]));
        // $prod_type4->detail_type()->save(ProductAccountDetailType::create(['name'=>"Land"]));
        // $prod_type4->detail_type()->save(ProductAccountDetailType::create(['name'=>"Leasehold Improvements"]));
        // $prod_type4->detail_type()->save(ProductAccountDetailType::create(['name'=>"Machinery and equipment"]));
        // $prod_type4->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other fixed assets"]));
        // $prod_type4->detail_type()->save(ProductAccountDetailType::create(['name'=>"Vehicles"]));
        // $prod_type5 = ProductAccountType::find(5);
        // $prod_type5->detail_type()->save(ProductAccountDetailType::create(['name'=>"Accumulated amortisation of non-current assets"]));
        // $prod_type5->detail_type()->save(ProductAccountDetailType::create(['name'=>"Assets held for sale"]));
        // $prod_type5->detail_type()->save(ProductAccountDetailType::create(['name'=>"Deferred tax"]));
        // $prod_type5->detail_type()->save(ProductAccountDetailType::create(['name'=>"Goodwill"]));
        // $prod_type5->detail_type()->save(ProductAccountDetailType::create(['name'=>"Intangible Assets"]));
        // $prod_type5->detail_type()->save(ProductAccountDetailType::create(['name'=>"Lease Buyout"]));
        // $prod_type5->detail_type()->save(ProductAccountDetailType::create(['name'=>"Licences"]));
        // $prod_type5->detail_type()->save(ProductAccountDetailType::create(['name'=>"Long-term investments"]));
        // $prod_type5->detail_type()->save(ProductAccountDetailType::create(['name'=>"Organisational Costs"]));
        // $prod_type5->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other non-current assets"]));
        // $prod_type5->detail_type()->save(ProductAccountDetailType::create(['name'=>"Security Deposits"]));
        // $prod_type6 = ProductAccountType::find(6);
        // $prod_type6->detail_type()->save(ProductAccountDetailType::create(['name'=>"Accounts Payable (A/P)"]));
        // $prod_type7 = ProductAccountType::find(7);
        // $prod_type7->detail_type()->save(ProductAccountDetailType::create(['name'=>"Credit card"]));
        // $prod_type8 = ProductAccountType::find(8);
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Accrued liabilities"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Client Trust Accounts - Liabilities"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Current Tax Liability"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Current portion of obligations under finance leases"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Dividends payable"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Income tax payable"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Insurance payable"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Line of Credit"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Loan Payable"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other current liabilities"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Payroll Clearing"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Payroll liabilities"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Prepaid Expenses Payable"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Rents in trust - Liability"]));
        // $prod_type8->detail_type()->save(ProductAccountDetailType::create(['name'=>"Sales and service tax payable"]));
        // $prod_type9 = ProductAccountType::find(9);
        // $prod_type9->detail_type()->save(ProductAccountDetailType::create(['name'=>"Accrued holiday payable"]));
        // $prod_type9->detail_type()->save(ProductAccountDetailType::create(['name'=>"Accrued non-current liabilities"]));
        // $prod_type9->detail_type()->save(ProductAccountDetailType::create(['name'=>"Liabilities related to assets held for sale"]));
        // $prod_type9->detail_type()->save(ProductAccountDetailType::create(['name'=>"Long-term debt"]));
        // $prod_type9->detail_type()->save(ProductAccountDetailType::create(['name'=>"Notes Payable"]));
        // $prod_type9->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other non-current liabilities"]));
        // $prod_type9->detail_type()->save(ProductAccountDetailType::create(['name'=>"Shareholder Notes Payable"]));
        // $prod_type10 = ProductAccountType::find(10);
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Accumulated adjustment"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Dividend disbursed"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Equity in earnings of subsidiaries"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Opening Balance Equity"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Ordinary shares"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other comprehensive income"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Owner's Equity"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Paid-in capital or surplus"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Partner Contributions"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Partner Distributions"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Partner's Equity"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Preferred shares"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Retained Earnings"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Share capital"]));
        // $prod_type10->detail_type()->save(ProductAccountDetailType::create(['name'=>"Treasury Shares"]));
        // $prod_type11 = ProductAccountType::find(11);
        // $prod_type11->detail_type()->save(ProductAccountDetailType::create(['name'=>"Discounts/Refunds Given"]));
        // $prod_type11->detail_type()->save(ProductAccountDetailType::create(['name'=>"Non-Profit Income"]));
        // $prod_type11->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other Primary Income"]));
        // $prod_type11->detail_type()->save(ProductAccountDetailType::create(['name'=>"Revenue - General"]));
        // $prod_type11->detail_type()->save(ProductAccountDetailType::create(['name'=>"Sales - retail"]));
        // $prod_type11->detail_type()->save(ProductAccountDetailType::create(['name'=>"Sales - wholesale"]));
        // $prod_type11->detail_type()->save(ProductAccountDetailType::create(['name'=>"Sales of Product Income"]));
        // $prod_type11->detail_type()->save(ProductAccountDetailType::create(['name'=>"Service/Fee Income"]));
        // $prod_type11->detail_type()->save(ProductAccountDetailType::create(['name'=>"Unapplied Cash Payment Income "]));
        // $prod_type12 = ProductAccountType::find(12);
        // $prod_type12->detail_type()->save(ProductAccountDetailType::create(['name'=>"Dividend income"]));
        // $prod_type12->detail_type()->save(ProductAccountDetailType::create(['name'=>"Interest earned"]));
        // $prod_type12->detail_type()->save(ProductAccountDetailType::create(['name'=>"Loss on disposal of assets"]));
        // $prod_type12->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other Investment Income"]));
        // $prod_type12->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other Miscellaneous Income"]));
        // $prod_type12->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other operating income"]));
        // $prod_type12->detail_type()->save(ProductAccountDetailType::create(['name'=>"Tax-Exempt Interest"]));
        // $prod_type12->detail_type()->save(ProductAccountDetailType::create(['name'=>"Unrealised loss on securities, net of tax"]));
        // $prod_type13 = ProductAccountType::find(13);
        // $prod_type13->detail_type()->save(ProductAccountDetailType::create(['name'=>"Cost of labour - COS"]));
        // $prod_type13->detail_type()->save(ProductAccountDetailType::create(['name'=>"Equipment rental - COS"]));
        // $prod_type13->detail_type()->save(ProductAccountDetailType::create(['name'=>"Freight and delivery - COS"]));
        // $prod_type13->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other costs of sales - COS"]));
        // $prod_type13->detail_type()->save(ProductAccountDetailType::create(['name'=>"Supplies and materials - COS"]));
        // $prod_type14 = ProductAccountType::find(14);
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Advertising/Promotional"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Amortisation expense"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Auto"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Bad debts"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Bank charges"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Charitable Contributions"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Commissions and fees"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Cost of Labour"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Dues and Subscriptions"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Equipment rental"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Finance costs"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Income tax expense"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Insurance"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Interest paid"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Legal and professional fees"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Loss on discontinued operations, net of tax"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Management compensation"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Meals and entertainment"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Office/General Administrative Expenses"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other Miscellaneous Service Cost"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other selling expenses"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Payroll Expense"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Rent or Lease of Buildings"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Repair and maintenance"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Shipping and delivery expense"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Supplies and materials"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Taxes paid"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Travel expenses - general and admin expenses"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Travel expenses - selling expense"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Unapplied Cash Bill Payment Expense"]));
        // $prod_type14->detail_type()->save(ProductAccountDetailType::create(['name'=>"Utilities"]));
        // $prod_type15 = ProductAccountType::find(15);
        // $prod_type15->detail_type()->save(ProductAccountDetailType::create(['name'=>"Amortisation"]));
        // $prod_type15->detail_type()->save(ProductAccountDetailType::create(['name'=>"Depreciation"]));
        // $prod_type15->detail_type()->save(ProductAccountDetailType::create(['name'=>"Exchange Gain or Loss"]));
        // $prod_type15->detail_type()->save(ProductAccountDetailType::create(['name'=>"Other Expense"]));
        // $prod_type15->detail_type()->save(ProductAccountDetailType::create(['name'=>"Penalties and settlements"]));

        //set owners equity account
        // $helper = new \App\helpers\HelperFunctions();
        // $practice = Practice::find(2);
        // $practice->chart_accounts()->create([
        //     'name'=>"Opening Balance Equity",
        //     'description'=>"Description",
        //     'account_type_id'=>10,
        //     'account_detail_type_id'=>70,
        //     'account_number'=>strtoupper($helper->getToken(10)),
        // ]);
        // $practice->chart_accounts()->create([
        //     'name'=>"Inventory",
        //     'description'=>"Inventory",
        //     'account_type_id'=>2,
        //     'account_detail_type_id'=>6,
        //     'account_number'=>strtoupper($helper->getToken(10)),
        // ]);
        // $practice->chart_accounts()->create([
        //     'name'=>"Inventory Assets",
        //     'description'=>"Inventory Assets",
        //     'account_type_id'=>2,
        //     'account_detail_type_id'=>6,
        //     'account_number'=>strtoupper($helper->getToken(10)),
        // ]);
        // $practice->chart_accounts()->create([
        //     'name'=>"Allowance for bad debts",
        //     'description'=>"Allowance for bad debts",
        //     'account_type_id'=>2,
        //     'account_detail_type_id'=>2,
        //     'account_number'=>strtoupper($helper->getToken(10)),
        // ]);
        // $practice->chart_accounts()->create([
        //     'name'=>"Available for sale assets (short-term)",
        //     'description'=>"Available for sale assets (short-term)",
        //     'account_type_id'=>2,
        //     'account_detail_type_id'=>3,
        //     'account_number'=>strtoupper($helper->getToken(10)),
        // ]);
        // $practice->chart_accounts()->create([
        //     'name'=>"Sales",
        //     'description'=>"Sales",
        //     'account_type_id'=>11,
        //     'account_detail_type_id'=>88,
        //     'account_number'=>strtoupper($helper->getToken(10)),
        // ]);
        // $practice->chart_accounts()->create([
        //     'name'=>"Sale retails",
        //     'description'=>"Sale retails",
        //     'account_type_id'=>11,
        //     'account_detail_type_id'=>86,
        //     'account_number'=>strtoupper($helper->getToken(10)),
        // ]);

        $hospital = Hospital::find(1);

        //Formulation-------------today
        // ProductFormulation::create(['name'=>'Tablets','description'=>'description','default_sys'=>true]);
        // ProductFormulation::create(['name'=>'Enteric Coated Tablets','description'=>'description','default_sys'=>true]);
        // ProductFormulation::create(['name'=>'Controlled Release Tablet','description'=>'description','default_sys'=>true]);
        // ProductFormulation::create(['name'=>'Sustained release preparations','description'=>'description','default_sys'=>true]);
        // ProductFormulation::create(['name'=>'Capsules','description'=>'description','default_sys'=>true]);
        // ProductFormulation::create(['name'=>'Oral preparations','description'=>'description','default_sys'=>true]);
        // ProductFormulation::create(['name'=>'Topical Preparations','description'=>'description','default_sys'=>true]);
        // ProductFormulation::create(['name'=>'Sublingual and Buccal Administration','description'=>'description','default_sys'=>true]);
        // ProductFormulation::create(['name'=>'Rectal Administration','description'=>'description','default_sys'=>true]);
        // ProductFormulation::create(['name'=>'Parental Drug Administration','description'=>'description','default_sys'=>true]);
        // ProductFormulation::create(['name'=>'Other','description'=>'description','default_sys'=>true]);
        //Vaccines
        ProductVaccine::create(['name'=>'Influenza','default_sys'=>true]);
        ProductVaccine::create(['name'=>'Diphtheria-tetanus-pertussis (dTpa)','default_sys'=>true]);
        ProductVaccine::create(['name'=>'Measles-mumps-rubella (MMR)','default_sys'=>true]);

        // $prod_type = ProductType::create([-------------today
        //     'name' => 'Tablet/Capsules',
        //     'default_sys'=>true
        // ]);
        // $prod_type = ProductType::create([
        //     'name' => 'Tablet',
        //     'default_sys'=>true
        // ]);
        // $prod_type = ProductType::create([
        //     'name' => 'Capsules',
        //     'default_sys'=>true
        // ]);
        // $prod_type = ProductType::create([
        //     'name' => 'Syrup',
        //     'default_sys'=>true
        // ]);
        // $prod_type = ProductType::create([
        //     'name' => 'Mixture/Syrup',
        //     'default_sys'=>true
        // ]);
        // $prod_type = ProductType::create([
        //     'name' => 'Surgical',
        //     'default_sys'=>true
        // ]);
        // $prod_type = ProductType::create([
        //     'name' => 'Others',
        //     'default_sys'=>true
        // ]);

        // ProductProfile::create(['name'=>'Drugs','default_sys'=>true]);-------------today
        // ProductProfile::create(['name'=>'Pathology','default_sys'=>true]);
        //ProductProfile::create(['name'=>'Equipment','default_sys'=>true]);

        // ProductRoutes::create(['name'=>'Oral route','default_sys'=>true]);-------------today
        // ProductRoutes::create(['name'=>'Injection routes','default_sys'=>true]);
        // ProductRoutes::create(['name'=>'Sublingual and buccal routes','default_sys'=>true]);
        // ProductRoutes::create(['name'=>'Rectal route ','default_sys'=>true]);
        // ProductRoutes::create(['name'=>'Vaginal route','default_sys'=>true]);
        // ProductRoutes::create(['name'=>'Ocular route','default_sys'=>true]);
        // ProductRoutes::create(['name'=>'Otic route','default_sys'=>true]);
        // ProductRoutes::create(['name'=>'Nasal route','default_sys'=>true]);
        // ProductRoutes::create(['name'=>'Inhalation route','default_sys'=>true]);
        // ProductRoutes::create(['name'=>'Nebulization route','default_sys'=>true]);
        // ProductRoutes::create(['name'=>'Cutaneous route','default_sys'=>true]);
        // ProductRoutes::create(['name'=>'Transdermal route','default_sys'=>true]);
        // ProductRoutes::create(['name'=>'Other','default_sys'=>true]);

        // $hospital->product_units()->save(ProductUnit::create(['name'=>'Kilogram','slug'=>'Kg']));-------------today
        // $hospital->product_units()->save(ProductUnit::create(['name'=>'Millilitre','slug'=>'Ml']));
        // $hospital->product_units()->save(ProductUnit::create(['name'=>'Litre','slug'=>'Ltr']));
        // $hospital->product_units()->save(ProductUnit::create(['name'=>'Pieces','slug'=>'Pcs']));
        // $hospital->product_units()->save(ProductUnit::create(['name'=>'Carton','slug'=>'Ctn']));
        // $hospital->product_units()->save(ProductUnit::create(['name'=>'Grams','slug'=>'GM']));
        // $hospital->product_units()->save(ProductUnit::create(['name'=>'Set','slug'=>'Set']));
        // $hospital->product_units()->save(ProductUnit::create(['name'=>'N/A','slug'=>'N/A']));
        // $hospital->product_units()->save(ProductUnit::create(['name'=>'Grams','slug'=>'GM']));
        // $hospital->product_units()->save(ProductUnit::create(['name'=>'Inch','slug'=>'Inch']));

        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Exforge HCT']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Anacin AF']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Fosamax']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Zovirax']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Albuterol Inhalation Solution']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'ProAir RespiClick Powder Inhaler']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Aclovate']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Uroxatral']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Panretin gel']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Zyloprim']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Xanax']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Hexalen capsules']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Cordarone']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Elavil']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Exforge']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Norvasc']));
        $hospital->product_brands()->save(ProductBrand::create(['name' => 'Amoxil, Moxatag']));

        $hospital->product_brand_sector()->save(ProductBrandSector::create(['name'=>'Paracetamol']));
        $hospital->product_brand_sector()->save(ProductBrandSector::create(['name'=>'Acetaminophene']));
        $hospital->product_brand_sector()->save(ProductBrandSector::create(['name'=>'Clonazepam']));

        //DELETE
        
        
        // $hospital->product_category()->create(['name'=>'Tablet']);
        // $hospital->product_category()->create(['name'=>'Syrup']);
        // $hospital->product_category()->create(['name'=>'Other']);
        //DELETE
        // Manufacturer::create(['name' => 'Acichem Laboratories']);-------------today
        // Manufacturer::create(['name' => 'Jaskam & Company Ltd']);
        // Manufacturer::create(['name' => 'Cosmos Pharmaceutical Limited']);
        //DELETE
//         $manu = Manufacturer::find(1);
//         $prod = $hospital->products()->create([
//             'name' => 'USN Blue Lab Whey Protein Chocolate 454g',
//             'description' => 'BlueLab™ 100% Whey is an ultra-premium blend of the highest quality whey protein isolate, concentrate and hydrolysate for optimal muscle development, support and recovery.',
//         ]);
//         $manu->products()->save($prod);
//         $prod = $hospital->products()->create([
//             'name' => 'Amoxicillin 250mg Capsules 10\'s',
//             //'category_id' => 1,
//             'practice_id' => 1,
//             'description' => 'Amoxicillin 250mg capsules contains amoxicillin used in the treatment of bacterial infections.Amoxicillin is used to treat infections such as bronchitis,ear infection,gonorrhea,pneumonia,skin infections,throat infections,tonsillitis,chest infections and wounds.',
//         ]);
//         $manu->products()->save($prod);
//         $disc = Disclaimer::create(['description' => 'The following information is an educational aid only.It\'s not indicated as medical advice or treatment.Consult your Doctor on safety and effectiveness.']);
//         $prec = Precaution::create(['description' => 'Make sure you complete the course even if you start to feel better. It is better to take with food to avoid an upset stomach. Diarrhea may occur as a side effect but should stop when your course is complete. Inform your doctor if it doesn\'t stop or if you find blood in your stools. Discontinue Afyamkononi Amoxicillin 250mg and inform your doctor immediately if you get a rash, itchy skin, swelling of face and mouth, or have difficulty in breathing.Afyamkononi Amoxicillin 250mg Capsule should be used with caution in patients with kidney and liver disease. Dose adjustment of MYDAWA Amoxicillin 250mg Capsule may be needed.']);
//         $dos = Dosage::create(['description' => 'Take this medicine in the dose and duration as advised by your doctor. Swallow it as a whole. Do not chew, crush or break it. Afyamkononi Amoxicillin 250mg Capsule may be taken with or without food, but it is better to take it at a fixed time.']);

//         $prod->disclaimer()->save($disc);
//         $prod->precaution()->save($prec);
//         $prod->dosage()->save($dos);

//         $prod = $hospital->products()->create([
//             'name' => 'USN Blue Lab Whey Protein Chocolate 500g',
//             'practice_id' => 1,
//             //'manufacturer_id' => 1,
//             'description' => 'BlueLab™ 100% Whey is an ultra-premium blend of the highest quality whey protein isolate, concentrate and hydrolysate for optimal muscle development, support and recovery.',
//         ]);
//         $manu->products()->save($prod);

        
//         //Product type


//         //DELETE
//         Product::create(['name'=>'Amoxicillin','practice_id'=>1]);
//         Product::create(['name'=>'Acetaminophen','practice_id'=>1]);
//         //DELETE

//         //DELETE

//         //DELETE
//         ProductGeneric::create(['name'=>'amoxicillin','practice_id'=>1]);
//         ProductGeneric::create(['name'=>'acetaminophen (oral) (a SEET a MIN oh fen)','practice_id'=>1]);
//         ProductGeneric::create(['name'=>'alendronate tablet','practice_id'=>1]);
//         ProductGeneric::create(['name'=>'acyclovir capsule','practice_id'=>1]);
//         ProductGeneric::create(['name'=>'acyclovir tablet','practice_id'=>1]);





        // $drug = ProductType::all()->where('name','Drug')->first();
        // $product_routes = ProductAdministrationRoute::all();
        // foreach ($product_routes as $product_route){
        //     $drug->product_routes()->save($product_route);
        // }

        // $category = ProductCategory::all();
        // foreach ($category as $catego){
        //     $drug->product_category()->save($catego);
        // }

        // Department::create(['name' => 'Procurement','practice_id'=>2]);
        // Department::create(['name' => 'Finance','practice_id'=>2]);
//        Department::create(['name' => 'Accident and emergency (A&E)', 'description'=>'This department (sometimes called Casualty) is where you\'re likely to be taken if you\'ve called an ambulance in an emergency']);
//        Department::create(['name' => 'Anaesthetics','description'=>'Doctors in this department give anaesthetic for operations.']);
//        Department::create(['name' => 'Breast screening','description'=>'This unit screens women for breast cancer, either through routine mammogram examinations or at the request of doctors. It\'s usually linked to an X-ray department.']);
//        Department::create(['name' => 'Cardiology','description'=>'This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.']);
//        Department::create(['name' => 'Chaplaincy','description'=>'Chaplains promote the spiritual and pastoral wellbeing of patients, relatives and staff.']);
//        Department::create(['name' => 'Critical care','description'=>'Sometimes called intensive care, this unit is for the most seriously ill patients.']);
//        Department::create(['name' => 'Diagnostic imaging','description'=>'Formerly known as X-ray, this department provides a full range of diagnostic imaging services including:']);
//        Department::create(['name' => 'Discharge lounge','description'=>'Many hospitals now have discharge lounges to help your final day in hospital go smoothly.']);
//        Department::create(['name' => 'Ear nose and throat (ENT)','description'=>'The ENT department provides care for patients with a variety of problems']);
//        Department::create(['name' => 'Elderly services department','description'=>'Led by consultant physicians specialising in geriatric medicine, this department looks after a wide range of problems associated with the elderly']);
//        Department::create(['name' => 'Gastroenterology','description'=>'']);
//        Department::create(['name' => 'General surgery','description'=>'The general surgery ward covers a wide range of surgery']);
//        Department::create(['name' => 'Gynaecology','description'=>'These departments investigate and treat problems of the female urinary tract and reproductive organs, such as endometritis, infertility and incontinence.']);
//        Department::create(['name' => 'Haematology','description'=>'']);
//        Department::create(['name' => 'Maternity departments','description'=>'']);
//        Department::create(['name' => 'Microbiology','description'=>'']);
//        Department::create(['name' => 'Neonatal unit','description'=>'']);
//        Department::create(['name' => 'Nephrology','description'=>'']);
//        Department::create(['name' => 'Neurology','description'=>'']);
//        Department::create(['name' => 'Nutrition and dietetics','description'=>'']);
//        Department::create(['name' => 'Obstetrics and gynaecology units','description'=>'']);
//        Department::create(['name' => 'Occupational therapy','description'=>'']);
//        Department::create(['name' => 'Oncology','description'=>'']);
//        Department::create(['name' => 'Ophthalmology','description'=>'']);
//        Department::create(['name' => 'Orthopaedics','description'=>'']);
//        Department::create(['name' => 'Pain management clinics','description'=>'']);
//        Department::create(['name' => 'Pharmacy','description'=>'']);
//        Department::create(['name' => 'Physiotherapy','description'=>'']);
//        Department::create(['name' => 'Radiotherapy','description'=>'']);
//        Department::create(['name' => 'Renal unit','description'=>'']);
//        Department::create(['name' => 'Rheumatology','description'=>'']);
//        Department::create(['name' => 'Sexual health (genitourinary medicine)','description'=>'']);
//        Department::create(['name' => 'Urology','description'=>'']);

        //DELETE
//        ProductChartAccount::create(['name' => 'Sales','practice_id'=>2,'product_account_nature_id'=>1,'product_account_type_id'=>1]);
//        ProductChartAccount::create(['name' => 'Cash','practice_id'=>2,'product_account_nature_id'=>1,'product_account_type_id'=>1]);
//        ProductChartAccount::create(['name' => 'Inventory','practice_id'=>2,'product_account_nature_id'=>1,'product_account_type_id'=>1]);
//        ProductChartAccount::create(['name' => 'Accounts receivable','practice_id'=>2]);
//        ProductChartAccount::create(['name' => 'Accounts payable','practice_id'=>2]);
//        ProductChartAccount::create(['name' => 'Telephone Expense','practice_id'=>2]);
//        ProductChartAccount::create(['name' => 'Cost of goods','practice_id'=>2]);
//        ProductChartAccount::create(['name' => 'Tax payable','practice_id'=>2]);

//        ProductPaymentMethod::create(['name'=>'Cash','practice_id'=>2]);
//        ProductPaymentMethod::create(['name'=>'Cheque','practice_id'=>2]);
//        ProductPaymentMethod::create(['name'=>'EFT (Electronic Fund Transfer)','practice_id'=>2]);

        // $hospital->product_currency()->create(['name'=>'Shilling','slug'=>'KES','country_id'=>1]);
        // $hospital->product_currency()->create(['name'=>'Shilling','slug'=>'UGX','country_id'=>2]);
        // $hospital->product_currency()->create(['name'=>'Shilling','slug'=>'TZS','country_id'=>3]);

        //to be deleted
        // ProductBank::create([
        //     'bank_code' => 'KCB098',
        //     'bank_name' => 'KCB',
        // ]);
        // ProductBank::create([
        //     'bank_code' => 'COOP098',
        //     'bank_name' => 'Cooperative',
        // ]);
        // ProductBankBranch::create([
        //     'product_bank_id'=>1,
        //     'short_code'=>'09COES09',
        //     'branch_code'=>'CODE0987',
        //     'branch_name'=>'Haile Selasie Av',
        // ]);
        // ProductPracticeBank::create([
        //     'product_bank_id' => 1,
        //     'product_bank_branch_id' => 1,
        //     'account_number' => 9100000,
        //     'account_name' => 'AMREF AFRICA',
        //     'practice_id' => 2,
        // ]);

        $practice1 = Practice::find(1);
        $practice2 = Practice::find(2);
        $practice3 = Practice::find(3);
        //Chart of Accounts;
        // $charts = AccountsCoa::all()->where('sys_default',true);
        // foreach( $charts as $chart ){
        //     $charty = $practice1->chart_of_accounts()->create(['coa_id'=>$chart->id]);
        //     $charty2 = $practice2->chart_of_accounts()->create(['coa_id'=>$chart->id]);
        //     $charty3 = $practice3->chart_of_accounts()->create(['coa_id'=>$chart->id]);
        //     $hospital->chart_of_accounts()->save($charty);
        //     $hospital->chart_of_accounts()->save($charty2);
        //     $hospital->chart_of_accounts()->save($charty3);
        // }

        //Payment Type
        // $pay = $hospital->payment_types()->create(['name'=>'Cash']);
        // $pay = $hospital->payment_types()->create(['name'=>'Card']);
        // $pay1 = $hospital->payment_types()->create(['name'=>'Cheque']);
        // $pay2 = $hospital->payment_types()->create(['name'=>'Wire Transfer']);

        //banks
        // $bank_ac1 = $hospital->banks()->create(['ac_title'=>'Account 1','ac_number'=>3000001,'ac_type'=>'Account Type','bank_id'=>1,'branch_id'=>1]);
        // $practice1->bank_accounts()->save($bank_ac1);
        // $bank_ac2 = $hospital->banks()->create(['ac_title'=>'Account 2','ac_number'=>3000002,'ac_type'=>'Account Type','bank_id'=>1,'branch_id'=>1]);
        // $practice2->bank_accounts()->save($bank_ac2);
        // $bank_ac3 = $hospital->banks()->create(['ac_title'=>'Account 3','ac_number'=>3000003,'ac_type'=>'Account Type','bank_id'=>1,'branch_id'=>1]);
        // $practice3->bank_accounts()->save($bank_ac3);


        ProductReport::create(['name'=>'Drug Register','section'=>'Pharmacy MIS Reports','description'=>'Shows the medicine stock register based with medicine category details']);
        ProductReport::create(['name'=>'Details of Counter Sale','section'=>'Pharmacy MIS Reports','description'=>'Shows the sales bill list with medicine name details']);
        ProductReport::create(['name'=>'Stock Flow Statement','section'=>'Pharmacy MIS Reports','description'=>'Shows summary of medicine stock register with opening qty, in qty, out qty, lost qty and closing qty.']);
        ProductReport::create([
            'name'=>'Department Wise Stock Transfer Receive',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of stock transfer which is transfer from one department to another department'
        ]);
        ProductReport::create([
            'name'=>'Transaction Summary Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows the sales transaction summary with sales, sales return differentiate by IPD / OPD'
        ]);
        ProductReport::create([
            'name'=>'Adjustment Issue Summary Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of stock adjustment medicines'
        ]);
        ProductReport::create([
            'name'=>'Adjustment Receipt Summary Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of stock adjustment medicines'
        ]);
        ProductReport::create([
            'name'=>'Pharmacy Purchase Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows medicine purchase register'
        ]);
        ProductReport::create([
            'name'=>'Pharmacy Purchase Return Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows medicine purchase return register'
        ]);
        ProductReport::create([
            'name'=>'Monthly Expenditure Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>"It's client specific report based on the specific parameter to count monthly patient and collection."
        ]);
        ProductReport::create([
            'name'=>'Near Expiry Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'It will display the stock which is of new expiry date'
        ]);
        ProductReport::create([
            'name'=>'Pharmacy Summary Detail Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows the summary of total purchase medicines department wise'
        ]);
        ProductReport::create([
            'name'=>'Sales Register Details',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the medicine sales details'
        ]);
        ProductReport::create([
            'name'=>'Sales Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows medicine sales register'
        ]);
        ProductReport::create([
            'name'=>'Purchase Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows medicine purchase register'
        ]);
        ProductReport::create([
            'name'=>'Sales Return Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows medicine sales return register'
        ]);
        ProductReport::create([
            'name'=>'Purchase Return Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows medicine purchase return register'
        ]);
        ProductReport::create([
            'name'=>'Stock Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows pharmacy stock register with the details of (in qty, out qty, closing qty purchase price and sales price)'
        ]);
        ProductReport::create([
            'name'=>'Stock Detail Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows pharmacy stock register in detail with a batch number, expiry date, company name etc..'
        ]);
        ProductReport::create([
            'name'=>'Supplier wise Stock Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows pharmacy supplier wise stock register in detail'
        ]);
        ProductReport::create([
            'name'=>'Min. Stock Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows minimum stock register based on min. qty set in medicine master'
        ]);
        ProductReport::create([
            'name'=>'Max. Stock Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows maximum stock register based on max. qty set in medicine master'
        ]);
        ProductReport::create([
            'name'=>'Re-Order Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows re-order stock register based on re-order qty set in medicine master'
        ]);
        ProductReport::create([
            'name'=>'Expiry Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the records of medicines which has been expired'
        ]);
        ProductReport::create([
            'name'=>'Empty Stock Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows details of medicines whose qty is zero'
        ]);
        ProductReport::create([
            'name'=>'Supplier wise Ledger',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Show the stock details summary based on supplier'
        ]);
        ProductReport::create([
            'name'=>'Pharma Bill Collection Register Details',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the pharmacy bill collection according to the payment mode like cash, cheque, card, online etc.'
        ]);
        ProductReport::create([
            'name'=>'Pharma Bill Sharing',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the doctor sharing on total bill amount based on the percentage set in doctor master'
        ]);
        ProductReport::create([
            'name'=>'Pharma Bill Sharing Ref By',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the reference doctor sharing on total bill amount based on the percentage set in reference doctor master'
        ]);
        ProductReport::create([
            'name'=>'Pharmacy Payment Details',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of payment details done by patients like total bill amount and receipt amount'
        ]);
        ProductReport::create([
            'name'=>'Pharmacy Insurance Details',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of payment details done by patients like total bill amount and receipt amount against the insurance company'
        ]);
        ProductReport::create([
            'name'=>'Credit Bill And Daily Outstanding Summary',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows pharmacy paid unpaid and closing amount details'
        ]);
        ProductReport::create([
            'name'=>'Pharmacy Summary Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the pharmacy purchase stock summary with details of how much stock is issued to department and how much stock is issue to patient'
        ]);
        ProductReport::create([
            'name'=>'Stock Transfer Summary Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the stock transfer summary from one department to another department'
        ]);
        ProductReport::create([
            'name'=>'Department wise Stock Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Show the stock details summary department wise'
        ]);
        ProductReport::create([
            'name'=>'Pharmacy Ledger Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows supplier wise ledger report within qty out qty and closing qty'
        ]);
        ProductReport::create([
            'name'=>'Stock Adjustment Summary',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the stock adjustment summary report'
        ]);
        ProductReport::create([
            'name'=>'Detail of Issue To IPD Patient',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of IPD patient that how much stock has been issued to that patient'
        ]);
        ProductReport::create([
            'name'=>'Summary of Sales Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the date wise summary of total number of sales invoice generated daily with total collection amount'
        ]);
        ProductReport::create([
            'name'=>'Stock Register For H1',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the medicine stock register for the H1 category drugs'
        ]);
        ProductReport::create([
            'name'=>'Batchwise Stock Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the medicine stock batch wise'
        ]);
        ProductReport::create([
            'name'=>'Material Receipt Details',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows the supplier payment details against purchase bill'
        ]);
        ProductReport::create([
            'name'=>'Medicine Sales Detail For Walk-In Patient',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows medicine sales register for walk-in patients only'
        ]);
        ProductReport::create([
            'name'=>'Sales Register For H1',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the medicine sales register for H1 category drugs'
        ]);
        ProductReport::create([
            'name'=>'Sales Register - OPD',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows sales for OPD Patients only'
        ]);
        ProductReport::create([
            'name'=>'Sales Register - IPD',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows sales for IPD patients only'
        ]);
        ProductReport::create([
            'name'=>'Pharmacy Collection Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the collection register of pharmacy module'
        ]);
        ProductReport::create([
            'name'=>'Stock Register Summary',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows medicine stock summary with (medicine in, out, transfer and adjustment)'
        ]);
        ProductReport::create([
            'name'=>'Stock Receipt Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of stock receive from one department to another department'
        ]);
        ProductReport::create([
            'name'=>'Stock Issue Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of stock issued from one department to another department'
        ]);
        ProductReport::create([
            'name'=>'Short Access Statement Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows the summary of medicine stock with the receipt.'
        ]);
        ProductReport::create([
            'name'=>'Department Wise Collection Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the department wise sales bill summary with paid/pending and total amount details'
        ]);
        ProductReport::create([
            'name'=>'RoundNote Prescription Detail',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the prescription details which has been given in the round notes'
        ]);
        ProductReport::create([
            'name'=>'Item Wise Closing Stock',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows medicine wise closing stock summary.'
        ]);
        ProductReport::create([
            'name'=>'Department wise Purchase Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the purchase bill details department wise'
        ]);
        ProductReport::create([
            'name'=>'Department wise Purchase Return Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the purchase return bill details department wise'
        ]);
        ProductReport::create([
            'name'=>'Department wise Sales Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the sales bill details department wise'
        ]);
        ProductReport::create([
            'name'=>'Department wise Sales Return Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the sales return bill details department wise'
        ]);
        ProductReport::create([
            'name'=>'Department wise Stock Adjustment',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows pharmacy stock adjustment department wise'
        ]);
        ProductReport::create([
            'name'=>'Department wise Stock Transfer',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows pharmacy stock transfer details department wise'
        ]);
        ProductReport::create([
            'name'=>'Department wise Purchase Order',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows pharmacy stock order  details department wise'
        ]);
        ProductReport::create([
            'name'=>'Department Wise Stock Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the pharmacy stock register (in, out, closing qty) department wise'
        ]);
        ProductReport::create([
            'name'=>'Purchase VAT Register - 5.5%',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows purchase vat register based on VAT percentage 5.5 %'
        ]);
        ProductReport::create([
            'name'=>'Purchase VAT Register - 14.5%',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows purchase vat register based on VAT percentage 14.5 %'
        ]);
        ProductReport::create([
            'name'=>'Sales VAT Register - 5.5%',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows sales vat register based on VATpercentage 5.5 %'
        ]);
        ProductReport::create([
            'name'=>'Sales VAT Register - 14.5%',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows sales vat register based on VATpercentage 14.5 %'
        ]);
        ProductReport::create([
            'name'=>'Sales VAT Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows sales vat register  based on VAT percentage entered in sales invoice'
        ]);
        ProductReport::create([
            'name'=>'Purchase VAT Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows purchase vat register based on VAT percentage entered in purchase invoice'
        ]);
        ProductReport::create([
            'name'=>'Issue Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows the summary of total number of  medicine issued to patient'
        ]);
        ProductReport::create([
            'name'=>'Stock Valuation',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows stock valuation based on purchase rate with details of in, out and closing qty'
        ]);
        ProductReport::create([
            'name'=>'Pharmacy Sale Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows sales register details'
        ]);
        ProductReport::create([
            'name'=>'Expiry Forecasting',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of medicine which will be expired in near future with the days left'
        ]);
        ProductReport::create([
            'name'=>'Outstanding Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows pharmacy sales bill summary with all the details like total amount, received the amount, pending amount adjustment and return details summary.'
        ]);
        ProductReport::create([
            'name'=>'Cash Report Summary',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the cash summary report for pharmacy sales invoice'
        ]);
        ProductReport::create([
            'name'=>'Issue Summary Statement',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows summary of medicine issues to patient'
        ]);
        ProductReport::create([
            'name'=>'Issue To IPD Patient',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows the summary of issue medicine to IPD patient'
        ]);
        ProductReport::create([
            'name'=>'Product Receiving Details',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the detailed summary of medicines against the purchase bill'
        ]);
        ProductReport::create([
            'name'=>'Stock Transfer Detail to Other Department',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Stock Transfer Detail to Other Department'
        ]);
        ProductReport::create([
            'name'=>'Details of Return From IPD Patient',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of return medicine stock from IPD patient'
        ]);
        ProductReport::create([
            'name'=>'Purchase VAT Register - 12.5%',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows purchase vat register based on VATpercentage 12.5 %'
        ]);
        ProductReport::create([
            'name'=>'Sales VAT Register - 5%',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows sales vat register based on VAT percentage 5 %'
        ]);
        ProductReport::create([
            'name'=>'Purchase Return Details',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of purchase return details'
        ]);
        ProductReport::create([
            'name'=>'Pharma Purchase Collection Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' Shows pharmacy collection against particular supplier based on payment mode details like cash, cheque, credit card, online.'
        ]);
        ProductReport::create([
            'name'=>'Pharmacy Profit',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the pharmacy profit'
        ]);
        ProductReport::create([
            'name'=>'Doctor wise Sales Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the total number of patient and total amount of pharmacy sales against particular doctor'
        ]);
        ProductReport::create([
            'name'=>'Highest Selling Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the report for highest selling of  medicine according to last 1, 3, 6 month and last 1 year'
        ]);
        ProductReport::create([
            'name'=>'Lowest Selling Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the report for lowest selling of medicine according to last 1,3,6 month and last 1 year'
        ]);
        ProductReport::create([
            'name'=>'Payment Due reminders for suppliers',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of supplier with pending payment'
        ]);
        ProductReport::create([
            'name'=>'Company Sales Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows summary of sales invoice for insurance patient'
        ]);
        ProductReport::create([
            'name'=>'Refer Bill Sharing Charge wise',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows reference doctor sharing based on single medicine amount based on amount/percentage set in ref. share in reference doctor master'
        ]);
        ProductReport::create([
            'name'=>'Consignment Detail Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the consignment details report
            Item wise Ledger Report: Shows the  complete summary of single medicine with purchase date, sales date in, out and closing qty'
        ]);
        ProductReport::create([
            'name'=>'Purchase VAT Register - 13.5%',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows purchase vat register based on VAT percentage 13.5 %'
        ]);
        ProductReport::create([
            'name'=>'Sales VAT Register - 13.5%',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the sales vat register summary based on the VAT percentage 13.5'
        ]);
        ProductReport::create([
            'name'=>'Supplier Stock Register',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the summary of stock against particular supplier'
        ]);
        ProductReport::create([
            'name'=>'Stent Consumption Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' It Shows summary of stent with details of purchase price and sales price'
        ]);
        ProductReport::create([
            'name'=>'Bed Status Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the bed status report  for admitted patients'
        ]);
        ProductReport::create([
            'name'=>'SalesRegister NarcoticCategory',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the sales invoice summary with narcotic category which has been set in medicine master'
        ]);
        ProductReport::create([
            'name'=>'Pharma Stock Valuation',
            'section'=>'Pharmacy MIS Reports',
            'description'=>' It will Shows pharmacy stock valuation based on purchase rate i.e how much amount stock is currently available'
        ]);
        ProductReport::create([
            'name'=>'SalesRegister CC',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Its client specific report which Shows the sales register (entry was done in the different version of sales invoice )'
        ]);
        ProductReport::create([
            'name'=>'SSR Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows sales detail summary with the entries done in a specific version of the sales invoice.'
        ]);
        ProductReport::create([
            'name'=>'Tie up Company wise Sales Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows the sales bill summary for insured patients'
        ]);
        ProductReport::create([
            'name'=>'Tie up Company wise Sales Detail Report',
            'section'=>'Pharmacy MIS Reports',
            'description'=>'Shows sales bill summary in detail for insured patients'
        ]);
        //
        ProductReport::create([
            'name'=>'Tax Liability Report',
            'section'=>'Sales tax',
            'description'=>"This report shows the taxes you need to pay and the ones you've already paid."
        ]);
        ProductReport::create([
            'name'=>'VAT - Tax Detail Report',
            'section'=>'Sales tax',
            'description'=>'The detail report lists each transaction and, for each tax rate/area, totals the taxes, the taxable amounts, and the non-taxable and tax-exempt amounts.'
        ]);
        ProductReport::create([
            'name'=>'VAT - Tax Exception Report',
            'section'=>'Sales tax',
            'description'=>' VAT Act do apply to this turnover, the VAT rate is 0% (exempt). You do not need to calculate VAT for a particular item or service.'
        ]);
        ProductReport::create([
            'name'=>'VAT - Tax Summary Report',
            'section'=>'Sales tax',
            'description'=>'Generate VAT tax information that you can submit to the VAT tax authority.'
        ]);
        //
        ProductReport::create([
            'name'=>'Accounts receivable ageing detail',
            'section'=>'Who owes you',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Accounts receivable ageing summary',
            'section'=>'Who owes you',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Collections Report',
            'section'=>'Who owes you',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Customer Balance Detail',
            'section'=>'Who owes you',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Customer Balance Summary',
            'section'=>'Who owes you',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Invoice List',
            'section'=>'Who owes you',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Open Invoices',
            'section'=>'Who owes you',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Statement List',
            'section'=>'Who owes you',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Terms List',
            'section'=>'Who owes you',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Uninvoiced charges',
            'section'=>'Who owes you',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Uninvoiced time',
            'section'=>'Who owes you',
            'description'=>''
        ]);
        //
        ProductReport::create([
            'name'=>'Accounts payable ageing detail',
            'section'=>'What you owe',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Accounts payable ageing summary',
            'section'=>'What you owe',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Bill Payment List',
            'section'=>'What you owe',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Supplier Balance Detail',
            'section'=>'What you owe',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Supplier Balance Summary',
            'section'=>'What you owe',
            'description'=>''
        ]);
        ProductReport::create([
            'name'=>'Unpaid Bills',
            'section'=>'What you owe',
            'description'=>''
        ]);
        



        // for( $j=1; $j<=20; $j++ ){
        //     $practice1->product_stock()->create(['product_item_id'=>$j,'amount'=>200,'batch_number'=>'BN00'.$j,'mfg_date'=>date('2019-08-01'),'exp_date'=>date('2023-08-01')]);
        //     $practice2->product_stock()->create(['product_item_id'=>$j,'amount'=>200,'batch_number'=>'BN00'.$j,'mfg_date'=>date('2019-08-01'),'exp_date'=>date('2023-08-01')]);
        //     $practice3->product_stock()->create(['product_item_id'=>$j,'amount'=>200,'batch_number'=>'BN00'.$j,'mfg_date'=>date('2019-08-01'),'exp_date'=>date('2023-08-01')]);
        // }

        // for( $j=1; $j<=20; $j++ ){
        //     $practice1->product_stock()->create(['product_item_id'=>$j,'amount'=>5000,'batch_number'=>'BTN00'.$j,'mfg_date'=>date('2019-08-01'),'exp_date'=>date('2023-08-01')]);
        //     $practice2->product_stock()->create(['product_item_id'=>$j,'amount'=>5000,'batch_number'=>'BTN00'.$j,'mfg_date'=>date('2019-08-01'),'exp_date'=>date('2023-08-01')]);
        //     $practice3->product_stock()->create(['product_item_id'=>$j,'amount'=>5000,'batch_number'=>'BTN00'.$j,'mfg_date'=>date('2019-08-01'),'exp_date'=>date('2023-08-01')]);
        // }

        //$practice1->product_stock()->create(['product_item_id'=>1,'amount'=>200,'batch_number'=>'BN001','mfg_date'=>date('2019-08-01'),'exp_date'=>date('2023-08-01')]);

        //to be deleted
    }
}
