export const BASE_URL = "http://192.168.0.13:10000";
//export const BASE_URL = "http://localhost:10000";
// Comments
export const RTC_BASE_URL = "localhost";
export const RTC_HIS_PORT = "8090";
// API url:
export const BASE_API_URL = BASE_URL + '/api';
// Authentication:
export const LOGIN_URL = `${BASE_API_URL }/oauth/login`;
export const CHANGE_PASSWORD = `${BASE_API_URL }/oauth/change/password`;
export const USER_ACCEPT_INVITATION_URL = `${BASE_API_URL }/oauth/invitation`;
export const USER_INVITED_LOAD_URL = `${BASE_API_URL }/oauth/invitation/users`;
export const PRACTICE_ROLE_URL = `${BASE_API_URL }/practices/roles`;

//Localization API
export const COUNTRIES_URL = `${BASE_API_URL }/localization/countries`;

export const REGISTER = '';
//https://afyatele.com/api/practices/undefined/ICC
export const SVS_DASHBORD_URL =  id  => `${BASE_API_URL }/practices/${id}/ICC`;
export const INVENTORY_ITEMS_URL = id  => `${ BASE_API_URL }/${id}/Items`;
export const INVETORY_STOCK_URL = id  => `${BASE_API_URL }/practices/${id}/Items`;

//https://afyatele.com/api/practices/d1b185e7-3b4c-40c9-9551-acc263120b0a/Purchases
export const INVETORY_PURCHASES_URL = id  => `${ BASE_API_URL }/practices/${id}/Purchases`;

//https://afyatele.com/api/practices/d1b185e7-3b4c-40c9-9551-acc263120b0a/Suppliers
export const INVETORY_SUPPLIERS_URL = id  => `${BASE_API_URL }/practices/${id}/Suppliers`;

//https://afyatele.com/api/practices/d1b185e7-3b4c-40c9-9551-acc263120b0a/Practices
export const INVETORY_PRACTICES_URL = id  => `${ BASE_API_URL }/practices/${id}/Practices`;

//https://afyatele.com/api/practices/d1b185e7-3b4c-40c9-9551-acc263120b0a/Banks
export const INVETORY_BANK_URL = id  => `${BASE_API_URL }/practices/${id}/Banks`;

//https://afyatele.com/api/practices/d1b185e7-3b4c-40c9-9551-acc263120b0a/Banks;
export const PRODUCT_LIST_URL = `${ BASE_API_URL }/products`;
export const PRODUCT_URL = `${ BASE_API_URL }/products`;
export const PRODUCT_ITEMS_URL = `${ BASE_API_URL }/products/items`;
export const PRODUCT_STOCK_REPORTS_URL = `${ BASE_API_URL }/products/stocks/reports`;
export const PRODUCT_REPORTS_URL = `${ BASE_API_URL }/products/reports`;
export const PRODUCT_STOCK_URL = `${ BASE_API_URL }/products/stocks`;
export const PRODUCT_CATEGORIES_URL = `${ BASE_API_URL }/products/categories`;
export const PRODUCT_CURRENCY_URL = `${ BASE_API_URL }/products/currencies`;
export const PRODUCT_SUB_CATEGORIES_URL = `${ BASE_API_URL }/products/categories/subcategory`;
export const PRODUCT_ORDER_CATEGORIES_URL = `${ BASE_API_URL }/products/categories/orders`;
export const PRODUCT_GENERIC_URL = `${ BASE_API_URL }/products/generics`;
export const PRODUCT_PROFILES_URL = `${ BASE_API_URL }/products/profiles`;
export const PRODUCT_TYPES_URL = `${ BASE_API_URL }/products/types`;
export const PRODUCT_ROUTES_URL = `${ BASE_API_URL }/products/routes`;
export const PRODUCT_FORMULATIONS_URL = `${ BASE_API_URL }/products/formulations`;
export const PRODUCT_TAX_URL = `${ BASE_API_URL }/products/taxations`;
export const PRODUCT_MANUFACTURER_URL = `${ BASE_API_URL }/manufacturers`;
export const PRODUCT_UPLOAD_URL = `${ BASE_API_URL }/products/items/upload`;
export const PRODUCT_ATTRIBUTES_URL = `${ BASE_API_URL }/products/attributes`;
export const PRODUCT_ITEM_URL = `${ BASE_API_URL }/products/items`;
export const PRODUCT_BRANDS = `${ BASE_API_URL }/products/brands`;
export const PRODUCT_UNITS = `${ BASE_API_URL }/products/units`;
export const PRODUCT_BRAND_SECTORS = `${ BASE_API_URL }/products/brands/sectors`;
export const PRODUCT_NOTIFICATIONS = `${ BASE_API_URL }/products/notifications`;
// export const INV_SET_NOTIFICATIONS_ALERT = `${ BASE_API_URL }/products/notifications/alerts`;
export const PRODUCT_REQUISITIONS = `${ BASE_API_URL }/products/requisitions`; //supply
export const PRODUCT_SUPPLY = `${ BASE_API_URL }/products/supply`;
export const PRODUCT_GON = `${ BASE_API_URL }/products/supply/gon`;
export const PRODUCT_STORES = `${ BASE_API_URL }/products/stores`;

export const FACILITY_URL = `${BASE_API_URL }/practices`;

export const SEARCH_ITEM_URL = `${ BASE_API_URL }/search`;

export const PURCHASES_URL = `${ BASE_API_URL }/products/purchases`;
export const PURCHASES_PO_URL = `${ BASE_API_URL }/products/purchases/po`;
export const PURCHASES_FACILITY_URL = `${ BASE_API_URL }/products/purchases/facility`;
export const PURCHASES_ATTRIBUTES_URL = `${ BASE_API_URL }/products/purchases/initials`;

export const SUPPLIER_URL = `${ BASE_API_URL }/suppliers/vendors`;
export const SUPPLIERS_UPLOAD_URL = `${ BASE_API_URL }/suppliers/upload`;
export const SUPPLIER_COMPANIES_URL = `${ BASE_API_URL }/suppliers/companies`;
export const SUPPLIER_PO_URL = `${ BASE_API_URL }/suppliers/purchases/orders`;
export const SUPPLIER_PO_ASSETS_API = `${ BASE_API_URL }/suppliers/purchases/orders/assets`;
export const SUPPLIER_BILL_URL = `${ BASE_API_URL }/suppliers/bills`;
export const SUPPLIER_BILL_ASSETS_API = `${ BASE_API_URL }/suppliers/bills/assets`;
export const SUPPLIER_TERMS_API = `${ BASE_API_URL }/suppliers/terms`;
export const SUPPLIER_PAYMENTS_API = `${ BASE_API_URL }/suppliers/payments`;
export const SUPPLIER_PAYMENTS_ASSETS_API = `${ BASE_API_URL }/suppliers/payments/assets`;
export const SUPPLIER_RETURNS_API = `${ BASE_API_URL }/suppliers/purchases/returns`;
export const SUPPLIER_RETURNS_ASSETS_API = `${ BASE_API_URL }/suppliers/purchases/returns/assets`;
export const SUPPLIER_CREDITS_API = `${ BASE_API_URL }/suppliers/credits`;
export const SUPPLIER_REPORTS_API = `${ BASE_API_URL }/suppliers/reports`;

export const PRACTICES_API = `${ BASE_API_URL }/practices`;
export const PRACTICES_DASHBOARD_API = `${ BASE_API_URL }/practices/dashboard`;
export const PRACTICE_ROLES_API = `${ BASE_API_URL }/practices/roles`;
export const PRACTICE_USERS_API = `${ BASE_API_URL }/practices/users`;
export const PRACTICE_FINANCE_SETTING_API = `${ BASE_API_URL }/practices/finance`;
export const PERMISSIONS_API = `${ BASE_API_URL }/permissions`;

export const UPLOADS_API = `${ BASE_API_URL }/uploads`;
export const UPLOAD_SAVE_API = `${ BASE_API_URL }/uploads/create`;

export const ACCOUNTS_INITIALS = `${ BASE_API_URL }/accounting/initializations`;
export const CHART_OF_ACCOUNTS = `${ BASE_API_URL }/accounting/chart_of_accounts`; //to be deleted
export const COA_API = `${ BASE_API_URL }/accounting/accounts`;
export const CHART_OF_ACCOUNT_OPEN_BAL_API = `${ BASE_API_URL }/accounting/balances`;
export const CHART_OF_ACCOUNT_API = `${ BASE_API_URL }/accounting/chart_of_accounts`;
export const CHART_OF_ACCOUNTS_TYPES = `${ BASE_API_URL }/accounting/types`;
export const ACCOUNTS_JOURNAL = `${ BASE_API_URL }/accounting/reports/journals`;
export const ACCOUNTS_LEDGER = `${ BASE_API_URL }/accounting/reports/ledgers`;
export const ACCOUNTS_TRAIL = `${ BASE_API_URL }/accounting/reports/trail_balance`;
export const ACCOUNTS_BALANCE_SHEET = `${ BASE_API_URL }/accounting/reports/balance_sheet`;
export const ACCOUNTS_TAX_RETURNS = `${ BASE_API_URL }/accounting/taxation/returns`;
export const ACCOUNTS_TAX_RETURNS_PAYMENTS = `${ BASE_API_URL }/accounting/taxation/returns/payments`;
export const ACCOUNTS_TAXATIONS = `${ BASE_API_URL }/products/taxations`;
//Account Holders
export const ACCOUNTS_ACCOUNT = `${ BASE_API_URL }/accounting/accounts`;

//Banking
export const BANKING_ACCOUNTS_URL = `${ BASE_API_URL }/finance/banks/accounts`;
export const BANKING_ACCOUNTS_TYPES_URL = `${ BASE_API_URL }/finance/banks/accounts/types`;
export const BANKING_BANKS_URL = `${ BASE_API_URL }/finance/banks`;
export const BANKING_BRANCHES_URL = `${ BASE_API_URL }/finance/banks/branches`;
export const BANKING_TRANSACTIONS_URL = `${ BASE_API_URL }/finance/banks/transactions`;
export const BANKING_RECONCILIATIONS_URL = `${ BASE_API_URL }/finance/banks/reconciliations`;
//
//Customer APIs
export const CUSTOMERS_API = `${ BASE_API_URL }/customers/debtors`;
export const CUSTOMERS_DASHBOARD_API = `${ BASE_API_URL }/customers/dashboard`;
export const CUSTOMERS_TERMS_API = `${ BASE_API_URL }/customers/terms`;
export const CUSTOMERS_ESTIMATES_API = `${ BASE_API_URL }/customers/estimates`;
export const CUSTOMERS_SALES_ORDERS_API = `${ BASE_API_URL }/customers/sales_orders`;
export const CUSTOMERS_SALES_RECEIPT_API = `${ BASE_API_URL }/customers/receipts`;
export const CUSTOMERS_INVOICES_API = `${ BASE_API_URL }/customers/invoices`;
export const CUSTOMERS_RETAINER_INVOICES_API = `${ BASE_API_URL }/customers/invoices/retainers`;
export const CUSTOMERS_RECEIPT_API = `${ BASE_API_URL }/customers/receipts`;
export const CUSTOMERS_PAYMENTS_API = `${ BASE_API_URL }/customers/payments`;
export const CUSTOMERS_CREDIT_NOTES_API = `${ BASE_API_URL }/customers/creditnotes`;
//
export const REPORTING = `${ BASE_API_URL }/reportings`;

