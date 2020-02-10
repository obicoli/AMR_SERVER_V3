import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '../views/front/home';
import AcceptInvite from '../views/auth/password/AcceptInvite';
import PrivilegeAction from '../views/auth/password/AcceptMaster';
import Login from '../views/auth/login';
import PassEmail from '../views/auth/password/email';
import ResetPass from '../views/auth/password/reset';
import CreatePass from '../views/auth/password/create_password';
import DocReg from '../views/auth/signup/doctor';
import PatReg from '../views/auth/signup/patient';
import ActToken from '../views/auth/signup/token';
import SuccReg from '../views/auth/signup/success';
import ActReq from '../views/auth/signup/activation';
import InventoryHomepage from '../views/backend/pharmacy/pharmacist/InventoryHome';

//================Banking======================
import FinanceDashboard from "../views/backend/practice/banking/Dashboard";
import Banks from "../views/backend/practice/banking/banks/Index";
import BankBranches from "../views/backend/practice/banking/banks/BankBranches";
import BankAccounts from "../views/backend/practice/banking/banks/BankAccounts";
import BankTransactions from "../views/backend/practice/banking/banks/BankTransactions";
import Reconsiliation from "../views/backend/practice/banking/banks/Reconsiliation";
import BankReports from "../views/backend/practice/banking/banks/BankReports";
//================Banking Ends Here============

//===============================Facilities==========================================
import Facilities from "../views/backend/practice/adminstrative/facility/Index";
//===================================================================================

//===============================Departments==========================================
import Departments from "../views/backend/practice/departments/Index";
//===================================================================================

//import Homepage from '../views/backend/pharmacy/admin/Home';
//Inventory
//import Products from '../views/backend/pharmacy/product/Index' ProductPreview;
//===============================INVENTORY SETTINGS==================================
import InventoryDashboard from '../views/backend/practice/inventory/product/Dashboard';
import Inventory from '../views/backend/practice/inventory/Home';
import Products from '../views/backend/practice/inventory/product/Items';
import Category from '../views/backend/practice/inventory/product/Category';
// import ProductPreview from '../views/backend/practice/inventory/product/dashboard/ProductPreview';
// import LocationView from '../views/backend/practice/inventory/product/dashboard/LocationView';
// import Purchase from '../views/backend/practice/inventory/purchase/Purchase';
// import PurchaseReturs from '../views/backend/practice/inventory/purchase/returns/Index';
//===================================================Customer================
// import Sales from '../views/backend/practice/inventory/sales/Sales';
import Estimates from '../views/backend/practice/inventory/customer/quotes/Index';
import EstimateView from '../views/backend/practice/inventory/customer/quotes/View';
import SalesOrder from '../views/backend/practice/inventory/customer/salesorder/Index';
import SalesOrderView from '../views/backend/practice/inventory/customer/salesorder/View';
import RetainerInvoices from "../views/backend/practice/inventory/customer/RetainerInvoice";
import RecurInvoices from "../views/backend/practice/inventory/customer/invoices/RecurIndex";
import RecurInvoicesView from "../views/backend/practice/inventory/customer/invoices/RecurView";
import Invoices from '../views/backend/practice/inventory/customer/invoices/Index';
import InvoicesView from "../views/backend/practice/inventory/customer/invoices/View";
import RetainerIndex from '../views/backend/practice/inventory/customer/invoices/RetainerIndex';
import RetainerView from '../views/backend/practice/inventory/customer/invoices/RetainerView';
import SalesReceipts from '../views/backend/practice/inventory/customer/receipts/Index';
import SalesReceiptView from '../views/backend/practice/inventory/customer/receipts/View';
import PaymentReceived from '../views/backend/practice/inventory/customer/payments/Index';
import PaymentReceivedView from '../views/backend/practice/inventory/customer/payments/View';
import CreditNotes from '../views/backend/practice/inventory/customer/creditnote/Index';
import CreditNoteView from '../views/backend/practice/inventory/customer/creditnote/View';
import Customers from '../views/backend/practice/inventory/customer/Index';
import CustomerQv from "../views/backend/practice/inventory/customer/View"
import Dashboard from '../views/backend/practice/inventory/customer/Dashboard';
//import PaymentReceived from '../views/backend/practice/inventory/customer/Payments';
import CustomerReports from '../views/backend/practice/inventory/customer/reports/Index';
//===================================================Customer Ends===========
import StockLedger from '../views/backend/practice/inventory/stock/StockLedger';
import InTransit from '../views/backend/practice/inventory/stock/InTransit';

//===============Report and Config
import Reports from '../views/backend/practice/inventory/reports/Reports';
import AppSet from '../views/backend/practice/inventory/reports/AppSet';
import ManageUsers from '../views/backend/practice/adminstrative/users/Users';
import PasswordChange from '../views/backend/practice/adminstrative/users/Password';
import MyAccount from '../views/backend/practice/adminstrative/users/MyAccount';
import ControlUserAccess from '../views/backend/practice/adminstrative/users/UserAccess';
//===============Report & Config

// import InvSettings from '../views/backend/practice/inventory/settings/SetCategory';
// import SubCategory from '../views/backend/practice/inventory/settings/SubCategory';
// import OrderCategory from '../views/backend/practice/inventory/settings/OrderCategory';
// import Brands from '../views/backend/practice/inventory/settings/Brands';
import InvUnits from '../views/backend/practice/inventory/settings/InvUnits';
import InvTax from '../views/backend/practice/inventory/settings/InvTax';
import InvCurrency from '../views/backend/practice/inventory/settings/InvCurrency';
// import BrandSector from "../views/backend/practice/inventory/settings/BrandSector";
import InvSetNotifications from '../views/backend/practice/inventory/settings/InvNotifications';
import InvSetStores from '../views/backend/practice/inventory/settings/InvStores';
import InvSetSubStores from '../views/backend/practice/inventory/settings/InvSubStore';
import InvNotification from '../views/backend/practice/inventory/notifications/InvNotification';
import InvNotificationSms from '../views/backend/practice/inventory/notifications/InvNotificationSms';
import InvAlerts from '../views/backend/practice/inventory/notifications/InvAlerts';
//==============================================================================================

//===============================INVENTORY PURCHASE==============================================
// import IndexPurchase from '../views/backend/pharmacy/purchase/Purchases';
import POrders from '../views/backend/practice/inventory/purchase/po/Index';
// import PurchaseReturn from '../views/backend/practice/inventory/purchase/returns/Index';
import PurchaseReport from '../views/backend/practice/inventory/purchase/Dashboard';
import GRNList from '../views/backend/practice/inventory/purchase/grn/Index';
import SupplyIndex from '../views/backend/practice/inventory/supply/Index';
import GoodsOutNotes from '../views/backend/practice/inventory/supply/GoodsOutNotes';
import DriverIndex from '../views/backend/practice/inventory/supply/Driver';
import VehicleIndex from '../views/backend/practice/inventory/supply/Vehicle';
import OrderIndex from '../views/backend/practice/inventory/supply/Orders';
//import CreatePurchase from '../views/backend/pharmacy/purchase/CreateNew'
//===============================================================================================

//===============================INVENTORY REQUISITION==============================================
import Requisitions from '../views/backend/practice/inventory/requisitions/Index';
import StockRequistion from '../views/backend/practice/inventory/stock/StockRequistion';
//===============================================================================================

//===============================ACCOUNTINGS====================================================
import InvCoa from '../views/backend/practice/accounting/coa/Index';
import CoaTransaction from "../views/backend/practice/accounting/coa/CoaTransaction"
// import BankList from "../views/backend/practice/accounting/banks/BankList";
import GeneralLedger from '../views/backend/practice/accounting/statements/Ledger';
import GeneralJournal from '../views/backend/practice/accounting/statements/Journal';
import TrailBalance from '../views/backend/practice/accounting/statements/TrailBalances';
import AccountReport from '../views/backend/practice/accounting/statements/Reports';
// import ProfitLoss from '../views/backend/practice/accounting/statements/PL';
import ProfitLoss from '../views/backend/practice/accounting/statements/ProfitLoss';
import BalanceSheet from '../views/backend/practice/accounting/statements/BalanceSheet';
import VatHome from '../views/backend/practice/accounting/taxation/VatReturn';
import VatAdjustment from '../views/backend/practice/accounting/taxation/VatAdjustment';
import VatPayRefund from '../views/backend/practice/accounting/taxation/VatPayRefund';
import VatReports from '../views/backend/practice/accounting/taxation/VatReports';
import VatReturnReport from '../views/backend/practice/accounting/taxation/VatReturnView';
//==============================================================================================

//Inventory
//=======================================SUPPLIER MODULE=======================================
//import VendorList from '../views/backend/practice/inventory/vendors/Index';
import SupplierList from '../views/backend/practice/inventory/suppliers/Index';
import SupplierView from '../views/backend/practice/inventory/suppliers/View';
import ObalanceAdjust from '../views/backend/practice/inventory/suppliers/OpenBalanceAdjust';
import SupplierPo from '../views/backend/practice/inventory/suppliers/po/Index';
import PReturns from '../views/backend/practice/inventory/suppliers/sreturns/Index';
import PReturnView from '../views/backend/practice/inventory/suppliers/sreturns/View';
import PoView from '../views/backend/practice/inventory/suppliers/po/View';
import SupplierStatement from '../views/backend/practice/inventory/suppliers/Statement';
import SupplierBills from '../views/backend/practice/inventory/suppliers/bills/Index';
import SupplierBill from '../views/backend/practice/inventory/suppliers/bills/View';
import SupplierCreditNotes from '../views/backend/practice/inventory/suppliers/credits/Index';
import SupplierRecurBills from '../views/backend/practice/inventory/suppliers/bills/RecurIndex';
import SupplierExpense from '../views/backend/practice/inventory/suppliers/expenses/Index';
import SupplierRecurExpense from '../views/backend/practice/inventory/suppliers/expenses/RecurIndex';
import SupplierPurchase from '../views/backend/practice/inventory/suppliers/PurchaseIndex';
import SupplierReceiveIndex from '../views/backend/practice/inventory/suppliers/ReceiveIndex';
import PaymentsMade from '../views/backend/practice/inventory/suppliers/payments/Index';
import PaymentView from '../views/backend/practice/inventory/suppliers/payments/View';
import SupplierReports from '../views/backend/practice/inventory/suppliers/reports/Index';
import ProdCategory from '../views/backend/pharmacy/product/ProdCategory';
import SupplierDashboard from '../views/backend/practice/inventory/suppliers/Dashboard';
//import InventoryDashboard from '../views/backend/practice/inventory/InventoryDashboard';
//=======================================SUPPLIER MODULE ENDS=======================================

//import AddItem from '../views/backend/pharmacy/product/AddItem';
import AddStock from '../views/backend/pharmacy/product/AddStock';
import ConsumeStock from '../views/backend/pharmacy/product/ConsumeStock';

//Initialization
// import BranchIndex from '../views/backend/pharmacy/initialization/branches/Index';
// import BranchCreate from '../views/backend/pharmacy/initialization/branches/Create';
// import BranchView from '../views/backend/pharmacy/initialization/branches/View';
// import DeptIndex from '../views/backend/pharmacy/initialization/departments/Index';
// import BraStores from '../views/backend/pharmacy/initialization/stores/BraStores';
// import SubStores from '../views/backend/pharmacy/initialization/stores/SubStores';
// import CategoryIndex from '../views/backend/pharmacy/initialization/categories/CateIndex';
//import Brands from '../views/backend/pharmacy/initialization/brands/Brands';
//import BrandSector from '../views/backend/pharmacy/initialization/brands/BrandSector';
// import MeasureUnit from '../views/backend/pharmacy/initialization/brands/MeasureUnit';
// import Currency from '../views/backend/pharmacy/initialization/brands/Currency';
//accounts
// import Accounts from '../views/backend/pharmacy/accounts/AccountIndex';
import Payee from '../views/backend/pharmacy/accounts/Payee';
//Human resource
// import HRIndex from '../views/backend/pharmacy/hr_depart/HRIndex';
//Reports

//
//Purchases

//Branch/facility
import AccountManager from '../views/backend/practice/accounting/AccountManager';
import FacilityAdmin from '../views/backend/practice/supplychain/Home';
import ScmWorkspace from "../views/backend/practice/supplychain/ScmWorkspace";
import SupplyHome from "../views/backend/practice/supplychain/DashboardHome";
//import FacilityDetails from '../views/backend/practice/adminstrative/FacilityDetails';
import FacilityDepartment from '../views/backend/practice/adminstrative/FacilityDepartment';
import BranchList from '../views/backend/practice/facilities/BranchList';

//HR
import FacilityHr from '../views/backend/practice/hresource/FacilityHr';
import UserReport from '../views/backend/practice/hresource/UserReport';
import UsersIndex from '../views/backend/practice/hresource/UsersIndex';//RolesIndex
import RolesIndex from '../views/backend/practice/hresource/RolesIndex'; //RolesIndex/administrative/manage/role
//import RoleView from '../views/backend/practice/hresource/RoleView';
//Billing: BillIndex
//import BillIndex from '../views/backend/practice/Billing/Index'
//Inventory: adminstrative
//import InvCurrency from '../views/backend/practice/adminstrative/ProductCurrency'
//import InvUnits from '../views/backend/practice/adminstrative/ProductUnit'
import InvService from '../views/backend/practice/adminstrative/ServiceBills'
import InvBrandSector from '../views/backend/practice/adminstrative/BrandSector'
import InvBrand from '../views/backend/practice/adminstrative/Brand';
import InvProductCategory from '../views/backend/practice/adminstrative/ProductCategory'
import InvBilling from '../views/backend/practice/adminstrative/Billing';
//Inventory: Accounts

//
import PharmDispense from "../views/backend/practice/departments/pharmacy/PharmDashboard";
import Pharmacy from "../views/backend/practice/departments/pharmacy/Dashboard";

//errors
import NotFound from '../views/errors/404'
import Err500 from '../views/errors/500'
import UnderRepaire from '../views/errors/maintanance'
//practices:

import Config from '../helpers/config'
import Auth from '../store/auth';
import {INVENTORY_WEB_ROUTES,ACCOUNTING_WEB_ROUTES,BANKS_WEB_ROUTES,ADMINSTRATIVE_WEB_ROUTES,DEPARTMENTS_WEB_ROUTES,REPORT_CONFIG_WEB_ROUTES,ADMINSTRATIVE} from '../router/web_routes';

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes: [
        {   path: '/', component: Home, meta: { title: Config.app_data.app_name+' - '+Config.app_data.app_description, guestUser: true } },
        {   path: '/login', component: Login, meta: { title: 'Login - '+Config.app_data.app_name, guestUser: true } },
        {   path: '/oauth/login', component: Login, meta: { title: 'Login - '+Config.app_data.app_name, guestUser: true } },
        {   path: '/forgot/password', component: PassEmail, meta: { title: Config.app_data.app_name+' | Forgot password', guestUser: true } },
        {   path: '/doctor/signup', component: DocReg, meta: { title: Config.app_data.app_name+' | Doctor registration', guestUser: true } },
        {   path: '/patient/signup', component: PatReg, meta: { title: Config.app_data.app_name+' | Patient registration', guestUser: true } },
        {   path: '/reset/password/:token', component: ResetPass, meta: { title: Config.app_data.app_name+' | Reset password', guestUser: true } },
        {   path: '/activate/:token', component: ActToken, meta: { title: Config.app_data.app_name+' | Activation required', guestUser: true } },
        {   path: '/oauth/login/:uuid/create/password', component: CreatePass, meta: { title: Config.app_data.app_name+' | Create password', guestUser: true } },
        {   path: '/registration/successful', component: SuccReg, meta: { title: Config.app_data.app_name+' | Successful registration', guestUser: true } },
        {   path: '/activation/required', component: ActReq, meta: { title: Config.app_data.app_name+' | Activation required', guestUser: true } },
        {   path: '/invitation/accept/:user_uuid/:uuid', component: AcceptInvite, meta: { title: Config.app_data.app_name+' | Invitation', guestUser: true } },
        {   path: '/privilege/:action/:token', component: PrivilegeAction, meta: { title: Config.app_data.app_name+' | Master Facility Administrator', authenticatedUser: true } },

        //{   path: '/inventory/dashboard', component: InventoryHomepage, meta: { title: 'Inventory Dashboard', authenticatedUser: true,accountSwitched: true } },
        //{   path: '/dashboard', component: Homepage, meta: { title: 'Dashboard', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.DASHBOARD, component: FacilityAdmin, meta: { title: 'Dashboard', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SCM_WORKSPACE, component: ScmWorkspace, meta: { title: 'My Workspace', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.DASHBOARD_HOME, component: SupplyHome, meta: { title: 'Dashboard', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //Inventory

        //===============================ADMINSTRATIVE==================================================
        {   path: ADMINSTRATIVE_WEB_ROUTES.FACILITIES, component: Facilities, meta: { title:'Facilities', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //==============================================================================================

        //===============================DEPARTMENT==================================================
        {   path: DEPARTMENTS_WEB_ROUTES.DEPARTMENTS, component: Departments, meta: { title:'Departments', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //==============================================================================================
        
        //===================Banks Starts
        {   path: BANKS_WEB_ROUTES.DASHBOARD, component: FinanceDashboard, meta: { title:'Finance Dashboard', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: BANKS_WEB_ROUTES.BANKS, component: Banks, meta: { title:'Banks', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: BANKS_WEB_ROUTES.BRANCHES, component: BankBranches, meta: { title:'Bank Branch', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: BANKS_WEB_ROUTES.ACCOUNTS, component: BankAccounts, meta: { title:'Bank Accounts', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: BANKS_WEB_ROUTES.TRANSACTIONS, component: BankTransactions, meta: { title:'Bank Transactions', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: BANKS_WEB_ROUTES.RECONSILIATION, component: Reconsiliation, meta: { title:'Bank Reconciliation', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: BANKS_WEB_ROUTES.REPORTS, component: BankReports, meta: { title:'Banking | Reports', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //==================Banks Ends Here

        //===============================ACCOUNTINGS====================================================
        {   path: ACCOUNTING_WEB_ROUTES.ACCOUNTS.COA, component: InvCoa, meta: { title:'Chart of Accounts', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.ACCOUNTS.COA_TRANSACTIONS, component: CoaTransaction, meta: { title:'Account View Report', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/accounts', component: Accounts, meta: { title:'Accounts', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: '/payee', component: Payee, meta: { title:'Accounts | Payee', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //Statements
        {   path: ACCOUNTING_WEB_ROUTES.TAXATION.REPORTS, component: VatReports, meta: { title:'Accounting |  VAT Reports', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.TAXATION.PAY_AND_REFUND, component: VatPayRefund, meta: { title:'Accounting |  VAT Payments and Refunds', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.TAXATION.ADJUSTMENTS, component: VatAdjustment, meta: { title:'Accounting | VAT Adjustments', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.TAXATION.FILING, component: VatHome, meta: { title:'Accounting | VAT Reports & Returns', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.TAXATION.FILING+'/:uuid/reports', component: VatReturnReport, meta: { title:'Accounting | VAT Reports & Returns', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: ACCOUNTING_WEB_ROUTES.STATEMENTS.TRAIL_BALANCE, component: TrailBalance, meta: { title:'Trail Balance', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.REPORTS, component: AccountReport, meta: { title:'Accounting | Reports', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.STATEMENTS.GENERAL_LEDGER, component: GeneralLedger, meta: { title:'General Ledger', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.STATEMENTS.GENERAL_JOURNAL, component: GeneralJournal, meta: { title:'General Journal', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.DASHBOARD, component: AccountManager, meta: { title:'Accounting', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.STATEMENTS.PL, component: ProfitLoss, meta: { title:'Profit & Loss', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.STATEMENTS.TRAIL_BALANCE, component: TrailBalance, meta: { title:'Trail Balance', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: ACCOUNTING_WEB_ROUTES.STATEMENTS.BALANCE_SHEET, component: BalanceSheet, meta: { title:'Balance Sheet', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //==============================================================================================

        // {   path: '/inventory/items', component: Products, meta: { title:'Inventory Items', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/item/:uuid/view', component: ProductPreview, meta: { title:'Product Preview', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/item/:uuid/locations_view', component: LocationView, meta: { title:'Facility Reporting', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/inventory/item/:uuid/preview', component: ProductPreview, meta: { title:'Inventory Items | Preview', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INVENTORIES.DASHBOARD, component: InventoryDashboard, meta: { title:'Inventory Dashboard', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_INVENTORY, component: Inventory, meta: { title:'Inventory', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INVENTORIES.ITEMS, component: Products, meta: { title:'Inventory Items', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INVENTORIES.CATEGORIES, component: Category, meta: { title:'Inventory | Categories', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //Customer Starts Here
        //{   path: INVENTORY_WEB_ROUTES.INV_PR, component: PurchaseReturs, meta: { title:'Purchase Returns', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.QUOTE, component: Estimates, meta: { title:'Estimates', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.QUOTE+'/:uuid/view', component: EstimateView, meta: { title:'Estimates', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: INVENTORY_WEB_ROUTES.SALES.RETAINER_INVOICES, component: RetainerInvoices, meta: { title:'Retainer Invoice', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.SALES_ORDERS, component: SalesOrder, meta: { title:'Sales Order', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.SALES_ORDERS+'/:uuid/view', component: SalesOrderView, meta: { title:'Sales Order', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.INVOICES, component: Invoices, meta: { title:'Invoice', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.INVOICES+'/:uuid/view', component: InvoicesView, meta: { title:'Invoice', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.INVOICES_RETAINER, component: RetainerIndex, meta: { title:'Retainer Invoices', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.INVOICES_RETAINER+'/:uuid/view', component: RetainerView, meta: { title:'Retainer Invoice', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.RECUR_INVOICES, component: RecurInvoices, meta: { title:'Recurring Invoices', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.RECUR_INVOICES+'/:uuid/view', component: RecurInvoicesView, meta: { title:'Recurring Invoice', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.SALES_RECEIPTS, component: SalesReceipts, meta: { title:'Sales Receipts', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.SALES_RECEIPTS+'/:uuid/view', component: SalesReceiptView, meta: { title:'Sale Receipt', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.PAYMENTS, component: PaymentReceived, meta: { title:'Payment Received', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.PAYMENTS+'/:uuid/view', component: PaymentReceivedView, meta: { title:'Payment Received', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.CREDIT_NOTES, component: CreditNotes, meta: { title:'Credit Notes', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.CREDIT_NOTES+'/:uuid/view', component: CreditNoteView, meta: { title:'Credit Note', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: INVENTORY_WEB_ROUTES.SALES.PAYMENTS, component: PaymentReceived, meta: { title:'Payment Received', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.CUSTOMERS, component: Customers, meta: { title:'Customers', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.CUSTOMERS+'/:uuid/QuickView', component: CustomerQv, meta: { title:'Customer | Quick View', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.CUSTOMERS_DASHBOARD, component: Dashboard, meta: { title:'Customer Overview', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.SALES.REPORTS, component: CustomerReports, meta: { title:'Customer Reports', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //Customer Ends Here
        {   path: INVENTORY_WEB_ROUTES.INV_STOCK, component: StockLedger, meta: { title:'Product Stock', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_STOCK_TRANSIT, component: InTransit, meta: { title:'In Transit', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_SUPPLY, component: SupplyIndex, meta: { title:'Inventory Transfer', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },//hasAccess:Auth.menuChecker('view.inv.supply')
        {   path: INVENTORY_WEB_ROUTES.INV_SUPPLY_GON, component: GoodsOutNotes, meta: { title:'Goods Out Notes', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },//hasAccess:Auth.menuChecker('view.inv.supply')
        {   path: INVENTORY_WEB_ROUTES.INV_SUPPLY_DRIVER, component: DriverIndex, meta: { title:'Driver', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_SUPPLY_VEHICLE, component: VehicleIndex, meta: { title:'Vehicles', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_SUPPLY_ORDERS, component: OrderIndex, meta: { title:'Order', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //Requisitions
        {   path: INVENTORY_WEB_ROUTES.INV_REQUISTION_DASHBOARD, component: Requisitions, meta: { title:'Requistion', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_REQUISTION, component: Requisitions, meta: { title:'Requistions', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //Report & Config
        {   path: REPORT_CONFIG_WEB_ROUTES.REPORTS, component: Reports, meta: { title:'Reports', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: REPORT_CONFIG_WEB_ROUTES.CONFIG, component: AppSet, meta: { title:'App Config', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //Report and Config Ends Here

        // {   path: INVENTORY_WEB_ROUTES.INV_SETTINGS, component: InvSettings, meta: { title:'Inventory Initialization', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: INVENTORY_WEB_ROUTES.INV_SET_CATEGORIES, component: InvSettings, meta: { title:'Categories', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: INVENTORY_WEB_ROUTES.INV_SET_SUB_CATEGORIES, component: SubCategory, meta: { title:'Sub Categories', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: INVENTORY_WEB_ROUTES.INV_SET_ORDER_CATEGORIES, component: OrderCategory, meta: { title:'Order Categories', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: INVENTORY_WEB_ROUTES.INV_SET_BRANDS, component: Brands, meta: { title:'Brands', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: INVENTORY_WEB_ROUTES.INV_SET_BRAND_SECTOR, component: BrandSector, meta: { title:'Brand Sector/Molecule', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: INVENTORY_WEB_ROUTES.INV_SET_UNITS , component: InvUnits, meta: { title:'Units', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: INVENTORY_WEB_ROUTES.INV_SET_CURRENCY  , component: InvCurrency, meta: { title:'Currency', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: INVENTORY_WEB_ROUTES.INV_SET_BRANDS, component: BrandSector, meta: { title:'Brand Sector/Molecule', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: INVENTORY_WEB_ROUTES.PURCHASES.VENDORS, component: SupplierList, meta: { title:'List of Suppliers', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //Suppliers Starts Here
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.VENDOR, component: SupplierView, meta: { title:'Supplier | Quick View', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.VENDOR_OPENING_BALANCE, component: ObalanceAdjust, meta: { title:'Suppliers | Opening Balance Adjustments', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: INVENTORY_WEB_ROUTES.PURCHASES.VENDOR, component: SupplierView, meta: { title:'Vendor Overview', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_ORDERS, component: SupplierPo, meta: { title:'Purchase Orders', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_ORDER, component: PoView, meta: { title:'Purchase Order', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.BILLS, component: SupplierBills, meta: { title:'Bills', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.BILL_VIEW, component: SupplierBill, meta: { title:'Bills', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.RECUR_BILLS, component: SupplierRecurBills, meta: { title:'Recurring Bills', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.RECEIVABLE, component: SupplierReceiveIndex, meta: { title:'Receivables', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.EXPENSES, component: SupplierExpense, meta: { title:'Expenses', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.PURCHASES, component: SupplierPurchase, meta: { title:'Purchases', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.RECUR_EXPENSES, component: SupplierRecurExpense, meta: { title:'Recurring Expenses', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.PAYMENTS, component: PaymentsMade, meta: { title:'Payments Made', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.BILL_PAYMENT, component: PaymentView, meta: { title:'Payment', authenticatedUser: true,requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.REPORTS, component: SupplierReports, meta: { title:'Supplier Reports', authenticatedUser: true,requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_RETURN, component: PReturns, meta: { title:'Purchase Returns', authenticatedUser: true,requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_RETURN+'/:uuid/view', component: PReturnView, meta: { title:'Purchase Return', authenticatedUser: true,requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.VENDOR_CREDIT, component: SupplierCreditNotes, meta: { title:'Vendor Credits', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.DASHBOARD, component: SupplierDashboard, meta: { title:'Supplier Dashboard', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //
        //Supplier Ends Here
        {   path: INVENTORY_WEB_ROUTES.PURCHASES.VENDOR_STATEMENT, component: SupplierStatement, meta: { title:'Vendor Statement', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_SET_NOTIFICATIONS, component: InvSetNotifications, meta: { title:'Notifications', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_SET_STORES, component: InvSetStores, meta: { title:'Stores', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_SET_SUB_STORES, component: InvSetSubStores, meta: { title:'Sub Stores', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_SET_TAX, component: InvTax, meta: { title:'Tax Rates', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_NOTIFICATIONS, component: InvNotification, meta: { title:'Inventory Notifications', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_SET_NOTIFICATIONS_ALERT, component: InvAlerts, meta: { title:'Inventory Alerts', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_NOTIFICATIONS_SMS, component: InvNotificationSms, meta: { title:'Inventory Notifications | SMS', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //purchases
        //{   path: '/purchases', component: IndexPurchase, meta: { title:'Purchases', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: INVENTORY_WEB_ROUTES.INV_PO, component: POrders, meta: { title:'Purchase Orders', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/purchase_returns', component: PurchaseReturn, meta: { title:'Returns', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: '/purchase/report', component: PurchaseReport, meta: { title:'Dashboard Report', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: '/good_received_note', component: GRNList, meta: { title:'Good Received Notes', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/inventory/items/add', component: AddItem, meta: { title:'Inventory | Add Item', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/inventory/category', component: ProdCategory, meta: { title:'Inventory | Categories', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/inventory/stock/add', component: AddStock, meta: { title:'Inventory | Add Stock', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/inventory/stock/consume', component: ConsumeStock, meta: { title:'Inventory | Consume Stock', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //pharmacy
        {   path: '/pharmacy', component: Pharmacy, meta: { title:'Pharmacy', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: '/pharmacy/prescription', component: PharmDispense, meta: { title:'Pharmacy | Dispensing', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },

        //{   path: '/settings/branches', component: BranchIndex, meta: { title:'Initialization | Branches', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/initialization/branches/create', component: BranchCreate, meta: { title:'Initialization | Create Branch', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/initialization/branch/view', component: BranchView, meta: { title:'Initialization | View Branch', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/initialization/departments', component: DeptIndex, meta: { title:'Initialization | Departments', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/initialization/stores', component: BraStores, meta: { title:'Initialization | Stores', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/initialization/sub_stores', component: SubStores, meta: { title:'Initialization | Sub Stores', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/settings/brands', component: Brands, meta: { title:'Settings | Brands', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/settings/brand_sector', component: BrandSector, meta: { title:'Settings | Brands Sector', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/settings/measure_units', component: MeasureUnit, meta: { title:'Settings | Brands, Units & Currency', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/settings/currency', component: Currency, meta: { title:'Settings | Brands, Units & Currency', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/settings/category', component: CategoryIndex, meta: { title:'Settings | Category', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: '/users/index/:role', component: UsersIndex, meta: { title:'Manage | Users', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: '/users/:roles', component: RolesIndex, meta: { title:'Manage | Roles', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {   path: '/system_users_summary', component: UserReport, meta: { title:'System Users', authenticatedUser: true } },
        //{   path: '/administrative/manage/role/:role_slug', component: RoleView, meta: { title:'Manage | Roles', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //
        //{   path: '/billing', component: BillIndex, meta: { title:'Billing | List', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //HR
        {   path: '/human_resources/employee/index/:url_slug', component: FacilityHr, meta: { title:'Employees', authenticatedUser: true, requirePharmacy: true, requireApproved:true,accountSwitched:true } },

        //Purchase
        //{   path: '/purchases/create', component: CreatePurchase, meta: { title:'Create Purchase', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },

        //branch settings level url
        {  path: ADMINSTRATIVE.USERS, component: ManageUsers, meta: { title:'Manage Users', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {  path: ADMINSTRATIVE.USER_ACCESS, component: ControlUserAccess, meta: { title:'Control User Access', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {  path: ADMINSTRATIVE.CHANGE_PASSWORD, component: PasswordChange, meta: { title:'Change Password', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        {  path: ADMINSTRATIVE.MY_ACCOUNT, component: MyAccount, meta: { title:'My Profile', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/svs/dashboard', component: InventoryDashboard, meta: { title:'Dashboard', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/facility/settings/details', component: FacilityDetails, meta: { title:'Details', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //{   path: '/facility/settings/departments', component: FacilityDepartment, meta: { title:'Departments', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/branches', component: BranchList, meta: { title:'Branches', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/inventory/settings/currency', component: InvCurrency, meta: { title:'Inventory | Currency Settings', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/inventory/settings/units', component: InvUnits, meta: { title:'Inventory | Unit Settings', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/inventory/settings/services', component: InvService, meta: { title:'Inventory | Service & Pricing', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/inventory/settings/brand_sector', component: InvBrandSector, meta: { title:'Inventory | Brand Sector', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/inventory/settings/brands', component: InvBrand, meta: { title:'Inventory | Brands', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/inventory/settings/product_category', component: InvProductCategory, meta: { title:'Inventory | Category', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        // {   path: '/inventory/settings/billing', component: InvBilling, meta: { title:'Inventory | Billing', authenticatedUser: true, requirePharmacy: true, requireApproved:true } },
        //Accounting: accounts



        ///
        ///purchases/
        //errors pages
        { path: '*', component: NotFound, meta: {  title: Config.app_data.app_name+' | 404 - Page Not Found'} },
        { path: '/under/maintenance', component: UnderRepaire, meta: {  title: Config.app_data.app_name+' | Under Maintenance'} },
        { path: '/500', component: Err500, meta: {  title: Config.app_data.app_name+' | 500-Internal Server Error'} },
    ]
});

export default router
