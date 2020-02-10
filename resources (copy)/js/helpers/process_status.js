export const PROCESS_STATUS = {
    PENDING : "Pending",
    PENDING_APPROVAL : "Pending Approval",
    APPROVED : "Approved",
    PARTIAL : "Partial",
    BILLED : "Billed",
    PARTIAL_BILLED : "Partial Billed",
    DELIVERED : "Delivered",
    SUBMITTED : "Submitted",
    DECLINED : "Declined",
    PRINTED : "Printed",
    PICKED : "Picked",
    PACKED : "Packed",
    SHIPPED : "Shipped",
    RECEIVED : "Received",
    DRAFT : "Draft",
    ACCEPTED: "Accepted",
    SENT: "Sent",
    EXPIRED: "Expired",
    INVOICED: "Invoiced",
    OPEN: "Open",
    CLOSED: "Closed",
    CANCELLED: "Cancelled",
    UNLOCATED: "Unlocated",
    RECONCILED: "Reconciled",
    REC_NOT_TICKED: "Not Ticked",
    REC_TICKED: "Ticked",
    PAID: "Paid",
    OVERDUE: "Overdue",
    UNPAID: "Unpaid",
    PARTIAL_PAID: "Partially Paid",
    VOID: "Void",
    ACTIVE: "Active",
}

export const TRANSACTION_TYPES = {
    
    PURCHASE_ORDER : "Purchase Order",
    BILL : "Bill",
    GRN_NOTE : "Goods Received Note",
    OPENING_BALANCE : "Opening Balance",
    CUSTOMER_OPENING_BALANCE : "Customer Opening Balance",
    SUPPLIER_OPENING_BALANCE : "Supplier Opening Balance",
    SUPPLIER_BILL : "Supplier Bill",
    SUPPLIER_PAYMENTS : "Supplier Payment",
    SUPPLIER_PAYMENTS : "Supplier Payment",
    ACCOUNT_OPENING_BALANCE : "Account Opening Balance",
    CUSTOMER_RECEIPT : "Customer Receipt",
    QUOTATION: "Quotation",
    SALES_ORDER: "Sales Order",
    OPENING_BALANCE: "Opening Balance",
    CUSTOMER_TRX: {
        CUSTOMER_RECEIPT : "Customer Receipt",
        CUSTOMER_PAYMENT : "Customer Payment",
    },
    ACCOUNT_TRX: {
        RECEIPT : "Account Receipt",
        PAYMENT : "Account Payment",
    },
    SUPPLIER_TRX: {
        PAYMENT : "Supplier Payment",
    },
    TRANSFER_TRX: {
        IN : "Transfer In",
        OUT : "Transfer Out",
    },
    VAT_TRX: {
        PAYMENT : "VAT Payment",
        REFUND : "VAT Refund",
    },

    CUSTOMER_REPORTS: {
        STATEMENT_RUN: "Customer Statement Run",
        LIST: "List of Customers",
        SALES_BY_CUST: "Sales by Customer",
        //SALES_BY_REP: "Sales by Sales Rep",
        OUTST_BALANCE: "Outstanding Balance",
        //CUST_STATE: "Customer Statement",
        CUST_TRX: "Customer Transactions",
        CUST_QUOT: "Customer Quotes",
        CUST_SORDER: "Customer Sales Order",
        CUST_INV: "Customer Invoices",
        UNLOC_RCPT: "Unalllocated Receipts",
        MAIL_SENT: "Email sent to Customers",
    },
    QUOTE_STATUS: {
        CANCELLED: "Cancelled",
        DRAFT : "Draft",
    },

    SUPPLIER: {
        PURCHASE_RETURN: "Purchase Return",
    },
    SUPPLIER_REPORTS: {
        R1: "List of Suppliers",
        R2: "Purchases by Supplier",
        R3: "Outstanding Balance",
        R4: "Supplier Statement",
        R5: "Supplier Transactions",
        R6: "Supplier Purchase Orders",
        R7: "Supplier Bills",
        R8: "Unallocated Payments",
        R9: "Emails sent to Supplier",
    },
    ACCOUNT_STATEMENTS: {
        TRAIL: "List of Suppliers",
        BL: "Purchases by Supplier",
        PL: "Outstanding Balance",
        R4: "Supplier Statement",
        R5: "Supplier Transactions",
        R6: "Supplier Purchase Orders",
        R7: "Supplier Bills",
        R8: "Unallocated Payments",
        R9: "Emails sent to Supplier",
    }
}

export const ADDRESS_TYPES = {
    BILLING : "Billing Address",
    SHIPPING : "Shipping Address",
}

export const SHIP_TO = {
    ORGANIZATION : "Organization",
    CUSTOMER : "Customer",
}

export const ACCOUNTING = {
    DEBIT : "Debit",
    CREDIT : "Credit",
    CURRENCY: "KES",
    ACCOUNT_NATURES: {
        ASSETS: "Assets",
        LIABILITY: "Liability",
        EQUITY: "Equity",
        REVENUE: "Revenue",
        EXPENSE: "Expense",
    },
    COA_NAMES: {
        AC_RECEIVABLE: "Accounts Receivable(A/R)",
        AC_PAYABLE: "Accounts Payable (A/P)",
        AC_INVENTORY: "Inventory",
    },
    ACCOUNT_REPORTS: {
        R1: "Journal Entries Report",
        R2: "Account Transaction",
        R3: "Audit Trail",
        R4: "System Audit Trail",
        R5: "Balance & VAT Adjustments",
    },
    /*
        WARNING! DO NOT EDIT/CHANGE THE ACCOUNT CODE CONSTANTS LISTED BELOW
    */
    COA_CODES: {
        INVENTORY: "107", //DO NOT EDIT OR CHANGE
        COS: "1004", //DO NOT EDIT OR CHANGE
        CLIENT_TRUST_CODE: "204", //DO NOT EDIT OR CHANGE
        AC_OPEN_BALANCE_EQUITY_CODE: "604", //DO NOT EDIT OR CHANGE
        AC_RETAINED_EARNING_CODE: "613", //DO NOT EDIT OR CHANGE
    }
    /*
        WARNING! DO NOT EDIT/CHANGE THE ACCOUNT CODE CONSTANTS LISTED ABOVE
    */
}

export const FORM_ACTIONS = {
    SAVE_NEW : "Save & New",
    SAVE_CLOSE : "Save & Close",
    SAVE_DRAFT : "Save As Draft",
    SAVE_OPEN : "Save As Open",
    SAVE_SEND : "Save & Send",
    SEND_MAIL: "Send Mail",
    PRINT: "Print",
    COMMENT: "Comment"
}

export const FILE_MIMES = {
    PDF : "application/pdf",
    IMG_PNG : "image/png",
    IMG_JPG : "image/jpg",
    IMG_JPG : "image/jpeg",
    IMG_GIF : "image/gif",
    DOC : "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    EXCEL_SHEET : "",
    CSV : "text/csv",
}

export const TAX_OPTIONS = {
    INCLUSIVE : "Inclusive of Tax",
    EXCLUSIVE : "Exclusive of Tax",
    OUT_OF_SCOPE : "Out of scope of Tax",
}
export const VAT_OPTIONS = {

    VAT_OPTIONS : {
        INCLUSIVE : "Inclusive of Tax",
        EXCLUSIVE : "Exclusive of Tax",
        OUT_OF_SCOPE : "Out of scope of Tax",
    },
    VIEW_BY : {
        VAT_PERIOD : "VAT Period",
        DATE : "Date",
        PERIOD_DESC: "Display transactions marked for a specific VAT period and return. Transactions back dated and marked as part of a different VAT return will not be displayed.",
        DATE_DESC: "Display transactions processed in the date range selected. Transactions processed and marked as part of different VAT periods and returns may be displayed.",
    },
    VAT_REPORTS: {
        REP1: "VAT Report",
        REP2: "VAT Summary Report",
        REP3: "VAT Transactions Report",
        REP4: "VAT Payments and Refunds Report",
    }

}

export const SIDEBARS = {
    CONFIG : "Configuration",
}

export const AC_TYPES = {
    CUSTOMER : "Customer",
    SUPPLIER : "Supplier",
    ACCOUNT : "Account",
    TRANSFER : "Transfer",
    VAT : "VAT"
}

export const DASHBOARD_REPORTS = {
    CUSTOMER_OUTSTANDING_BALANCE : "Top Customers by Outstanding Balance",
    SALES_HISTORY: "Sales History",
    BANKING: "Banking",
    PROFIT_LOSS: "Profit and Loss"
}

export const PAYMENT_OPTIONS = {
    CASH : "Cash",
    CREDIT: "Credit",
    CHEQUE: "Cheque",
    BANK_REMITTANCE: "Bank Remittance",
    BANK_TRANSFER: "Bank Transfer",
}

export const BANKING = {
    REPORTS: {
        BANK_ACCOUNTS: "Bank and Credit Card",
        BANK_TRANSACTIONS: "Bank Transactions",
        CASH_MOVEMENT: "Cash Movement",
        CASH_FLOW: "Cash Flow",
        BANK_FEED: "Bank Feed Audit Trail",
    }
}

export const REPORT_SECTIONS = {
    INVENTORY: "Inventory",
}

//https://easyerp.com/docs/inventory/transactions/
//https://easyerp.com/docs/inventory/stock-detail/
//https://easyerp.com/docs/inventory/goods-out-notes/
//https://help.brightpearl.com/hc/en-us/articles/211131226-Inventory-Transfers-Warehouse-to-Warehouse-
//https://www.brightpearl.com/knowledge/inventory-transfer

//https://printjs.crabbly.com/
//https://github.com/crabbly/Print.js/blob/master/test/manual/index.html
//https://www.vue2editor.com/guide.html#usage
//https://github.com/growthbunker/vuetimeline
