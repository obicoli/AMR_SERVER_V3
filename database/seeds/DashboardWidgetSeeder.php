<?php

use App\Models\Practice\Practice;
use App\Models\Practice\Settings\DashboardSetting;
use Illuminate\Database\Seeder;

class DashboardWidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DashboardSetting::create(['name'=>'Customer Balances - Days Outstanding','type'=>'Customer Widgets']);
        DashboardSetting::create(['name'=>'Top Customers by Sales','type'=>'Customer Widgets']);
        DashboardSetting::create(['name'=>'Top Customers by Outstanding Balance','type'=>'Customer Widgets']);
        DashboardSetting::create(['name'=>'Customer Payments Due','type'=>'Customer Widgets']);
        DashboardSetting::create(['name'=>'Customer Zone Notifications','type'=>'Customer Widgets']);

        DashboardSetting::create(['name'=>'Sales History','type'=>'Quotes and Sales Widgets']);
        DashboardSetting::create(['name'=>'Sales Orders','type'=>'Quotes and Sales Widgets']);
        DashboardSetting::create(['name'=>'Daily Sales History','type'=>'Quotes and Sales Widgets']);
        DashboardSetting::create(['name'=>'Quotes','type'=>'Quotes and Sales Widgets']);
        // DashboardSetting::create(['name'=>'Tax Invoices auto-processed from Recurring Invoices','type'=>'Quotes and Sales Widgets']);

        DashboardSetting::create(['name'=>'Supplier Balances - Days Outstanding','type'=>'Supplier Widgets']);
        DashboardSetting::create(['name'=>'Top Suppliers by Purchases','type'=>'Supplier Widgets']);
        DashboardSetting::create(['name'=>'Top Suppliers by Outstanding Balance','type'=>'Supplier Widgets']);
        DashboardSetting::create(['name'=>'Purchase History','type'=>'Supplier Widgets']);
        DashboardSetting::create(['name'=>'Supplier Payments Due','type'=>'Supplier Widgets']);

        DashboardSetting::create(['name'=>'Top Purchased Items','type'=>'Item Widgets']);
        DashboardSetting::create(['name'=>'Top Selling Items','type'=>'Item Widgets']);
        DashboardSetting::create(['name'=>'Top Items by Value On Hand','type'=>'Item Widgets']);

        DashboardSetting::create(['name'=>'Banking','type'=>'Banking Widgets']);
        DashboardSetting::create(['name'=>'Banks and Credit Cards','type'=>'Banking Widgets']);
        DashboardSetting::create(['name'=>'Cash Movement','type'=>'Banking Widgets']);

        DashboardSetting::create(['name'=>'To Do List','type'=>'Other Widgets']);
        DashboardSetting::create(['name'=>'Profit and Loss','type'=>'Other Widgets']);

        //
        $companies = Practice::all();
        $widgets = DashboardSetting::all();
        foreach( $companies as $company ){
            foreach($widgets as $widget){
                $company->dashboard_widgets()->save($widget);
            }
        }

    }
}
