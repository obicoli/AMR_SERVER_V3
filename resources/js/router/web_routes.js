export const LOGIN_URL = "/login";
export const INVENTORY_WEB_ROUTES = {

    INV_INVENTORY : "/inventory",
    DASHBOARD : "/dashboard",
    SCM_WORKSPACE : "/scm/dashboard/workspace",
    DASHBOARD_HOME : "/scm/dashboard/home",
    INVENTORIES: {
        DASHBOARD: "/inventory/dashboard",
        ITEMS: "/inventory/items",
        CATEGORIES: "/inventory/items/categories",
        REPORT: "/inventory/reports",
    },
    SALES:{
        QUOTE: "/customer/estimates",
        SALES_ORDERS: "/customer/orders",
        INVOICES: "/customer/invoices",
        INVOICES_RETAINER: "/customer/retainer_invoices",
        RECUR_INVOICES: "/customer/invoices/recurring",
        RETAINER_INVOICES: "/customer/retainer_invoices",
        SALES_RECEIPTS: "/customer/sales/receipts",
        CREDIT_NOTES: "/customer/credit/notes",
        PAYMENTS: "/customer/payments",
        ALL_TRANSACTIONS: "/customer/all_transactions",
        CUSTOMERS: "/customers",
        CUSTOMERS_DASHBOARD: "/customers/dashboard",
        REPORTS: "/customer/reports",
    },

    PURCHASES:{
        DASHBOARD : "/supplier/dashboard",
        VENDORS : "/suppliers/list_of_suppliers",
        //VENDOR : "/vendors/:uuid/overview",
        VENDOR : "/suppliers/:uuid/profile",
        VENDOR_OPENING_BALANCE : "/suppliers/opening_balance/adjustments",
        VENDOR_STATEMENT : "/vendors/:uuid/statement",
        PURCHASES : "/purchases",
        PAYMENTS : "/suppliers/payments",
        BILL_PAYMENT: "/suppliers/payments/:uuid/view",
        RECEIVABLE : "/purchases/receivables",
        PURCHASE_ORDERS : "/suppliers/purchase/orders",
        PURCHASE_ORDER : "/purchases/purchase_orders/:uuid/view",
        PURCHASE_RETURN : "/purchases/returns",
        BILLS : "/suppliers/bills",
        BILL_VIEW: "/suppliers/bills/:uuid/view",
        DEBIT_NOTES : "/purchases/debit_notes",
        VENDOR_CREDIT : "/purchases/supplier_credits",
        RECUR_BILLS : "/purchases/bills/recurring",
        EXPENSES : "/purchases/expenses",
        RECUR_EXPENSES : "/purchases/expenses/recurring",
        REPORTS: "/purchases/reports",
    },

    INV_PURCHASES : "/purchases",
    INV_ITEMS : "/inventory/items",
    INV_STOCK : "/inventory/stock",
    INV_STOCK_TRANSIT : "/inventory/stock/in_transit",
    INV_REQUISTION : "/requistions",
    INV_REQUISTION_DASHBOARD : "/requistion/dashboard",
    INV_SUPPLIERS : "/vendors",
    INV_SUPPLIER : "/vendor/:uuid/view",
    INV_REPORTS : "/inventory/reports",
    INV_PO : "/purchase/orders",
    INV_PR : "/purchase/returns",
    INV_SUPPLY : "/inventory/supply",
    INV_SUPPLY_DRIVER : "/supply/driver",
    INV_SUPPLY_VEHICLE : "/supply/vehicle",
    INV_SUPPLY_ORDERS : "/supply/orders",
    INV_SUPPLY_GON : "/supply/goods_out_note",
    // INV_PURCHASES : "/purchases",
    INV_SETTINGS : "/initialization",
    INV_SET_CATEGORIES : "/initialization/categories",
    INV_SET_SUB_CATEGORIES : "/initialization/sub_categories",
    INV_SET_ORDER_CATEGORIES : "/initialization/order_categories",
    INV_SET_BRANDS : "/initialization/brands",
    INV_SET_BRAND_SECTOR : "/initialization/brand/sector",
    INV_SET_STORES : "/initialization/stores",
    INV_SET_SUB_STORES : "/initialization/sub_stores",
    INV_SET_UNITS : "/initialization/units",
    INV_SET_CURRENCY : "/initialization/currency",
    INV_SET_NOTIFICATIONS : "/initialization/notifications",
    INV_NOTIFICATIONS : "/inventory/notifications",
    INV_NOTIFICATIONS_SMS : "/inventory/notifications/sms",
    INV_SET_NOTIFICATIONS_ALERT : "/inventory/notifications/alerts",
    INV_SET_TAX : "/settings/taxation",
}

export const ADMINSTRATIVE_WEB_ROUTES = {
    FACILITIES : "/facilities",
    USERS : "/users/index/all",
    ROLES : "/users/roles",
}

export const DEPARTMENTS_WEB_ROUTES = {
    DEPARTMENTS : "/departments",
}

export const ACCOUNTING_WEB_ROUTES = {
    DASHBOARD : "/accounting",
    BANKS : {
        BANK : "/accounts/chart_of_accounts",
        COA : "/accounts/chart_of_accounts",
        OPEN_ACCOUNT_HEAD : "/accounts/vouchers",
        CREDIT_VOUCHERS : "/accounts/credit_vouchers",
        DEBIT_VOUCHERS : "/accounts/debit_vouchers",
        JOURNAL_VOUCHERS : "/accounts/journal_vouchers",
        ACCOUNT_HOLDERS : "/accounts/payee",
    },
    ACCOUNTS : {
        INTRO : "/accounts/chart_of_accounts",
        COA : "/accounts",
        COA_TRANSACTIONS : "/accounts/:uuid/transactions/list",
        OPEN_ACCOUNT_HEAD : "/accounts/vouchers",
        CREDIT_VOUCHERS : "/accounts/credit_vouchers",
        DEBIT_VOUCHERS : "/accounts/debit_vouchers",
        JOURNAL_VOUCHERS : "/accounts/journal_vouchers",
        ACCOUNT_HOLDERS : "/accounts/payee",
    },
    STATEMENTS : {
        GENERAL_JOURNAL : "/statements/general/journal",
        GENERAL_LEDGER : "/statements/general/ledger",
        LEDGER_ACCOUNTS : "/statements/ledger/accounts",
        TRAIL_BALANCE : "/statements/trail/balance",
        INCOME : "/statements/income/statement",
        BALANCE_SHEET : "/statements/balance/sheet",
        PL : "/statements/profit/loss",
        BANK_RECONCILIATION : "/banks/reconsiliation",
    },
    TAXATION: {
        FILING: "/taxation/returns",
        PAY_AND_REFUND: "/taxation/payments_and_refunds",
        ADJUSTMENTS: "/taxation/adjustments",
        REPORTS: "/taxation/reports",
    },
    REPORTS: "/accounting/reports",
}

export const REPORT_CONFIG_WEB_ROUTES = {
    REPORTS : "/reports",
    CONFIG : "/company/settings",
}

export const ADMINSTRATIVE = {
    USER_ACCESS : "/manage/user/access",
    USERS : "/manage/users",
    CHANGE_PASSWORD: "/admin/change/password",
    MY_ACCOUNT: "/admin/my_account",
}

export const BANKS_WEB_ROUTES = {
    DASHBOARD : "/financial/dashboard",
    BANKS : "/banks",
    BRANCHES : "/banks/branches",
    ACCOUNTS : "/banks/accounts",
    TRANSACTIONS : "/banks/transactions",
    RECONSILIATION : "/banks/reconsiliation",
    REPORTS : "/banks/reports",
}
