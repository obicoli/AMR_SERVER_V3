import { ExportToCsv } from 'export-to-csv';
import moment from 'vue-moment';
import {ACCOUNTING,ADDRESS_TYPES,TRANSACTION_TYPES} from "../helpers/process_status";
import {VALIDATE_TOKEN_API} from "../router/api_routes";
import {get} from "../helpers/api";

export function paginator(paginated = null){
    if(paginated){
        return paginated.pagination;
    }else{
        return {
            'current_page': 1,
            'total': 1,
        }
    }
}

export function tokenValidator(){
    let results = false;
    get(VALIDATE_TOKEN_API)
    .then((res) => {
        if(res.data.status_code === 200) {
            results = true;
        }
    })
    .catch((err) => {
        results = false;
    });
    return results;
}

export function printing(element_id,msg=null) {
    if(msg===null){
        msg = "Loading...";
    }
    printJS({
        printable: element_id,
        type: "html",
        css: [
            'https://fonts.googleapis.com/css?family=Open+Sans|Raleway|Candal',
            'http://localhost:8000/assets/bootstrap/css/bootstrap.min.css',
            'http://localhost:8000/assets/fonts/fontawesome/css/font-awesome.css',
            'http://localhost:8000/assets/plugins/css/import-font.css',
            'http://localhost:8000/assets/dist/css/custom-style.css'
        ],
        scanStyles: false,
        showModal: true,
        modalMessage: msg,
        onPrintDialogClose: () => console.log("The print dialog was closed"),
        onError: e => console.log(e)
    });
}

export function format_lunox_date(date_to_format){
    let lunox_str = "T00:00:00.000Z";
    if(date_to_format.includes(lunox_str)){
        return date_to_format.replace(lunox_str, "")
    }else{
        return date_to_format+""+lunox_str;
    }
}

export function check_opening_balance_transaction(account_nature,account_code,report_transact,stop_at_index){

    if(report_transact.support_document.trans_type === TRANSACTION_TYPES.ACCOUNT_OPENING_BALANCE){
        const assets_ = ACCOUNTING.ACCOUNT_NATURES.ASSETS;
        const liability_ = ACCOUNTING.ACCOUNT_NATURES.LIABILITY;
        const expense_ = ACCOUNTING.ACCOUNT_NATURES.EXPENSE;
        const revenue_ = ACCOUNTING.ACCOUNT_NATURES.REVENUE;
        const equity_ = ACCOUNTING.ACCOUNT_NATURES.EQUITY;
        if( account_nature===assets_ || account_nature===expense_ ){
            if(report_transact.double_entry.debited === account_code){
                return true
            }else{
                return false;
            }
        }else{

            if(report_transact.double_entry.credited === account_code){
                return true
            }else{
                return false;
            }

        }
        return true;
    }else{
        return false;
    }

}

export function calculate_account_bal(account_nature,account_code,stop_at_index,transactions=[]){

    const assets_ = ACCOUNTING.ACCOUNT_NATURES.ASSETS;
    const liability_ = ACCOUNTING.ACCOUNT_NATURES.LIABILITY;
    const expense_ = ACCOUNTING.ACCOUNT_NATURES.EXPENSE;
    const revenue_ = ACCOUNTING.ACCOUNT_NATURES.REVENUE;
    const equity_ = ACCOUNTING.ACCOUNT_NATURES.EQUITY;

    if( account_nature===assets_ || account_nature===expense_ ){

        let total_debit = 0;
        let total_credit = 0;
        let total = 0;
        let total_obj = {
            total_debit: 0,
            total_credit: 0,
            total: 0,
            calculate_done: false
        };
        for (let index = 0; index < transactions.length; index++){
            const double_entry = transactions[index].double_entry;
            if( (double_entry.debited===account_code) || (double_entry.debited_parent===account_code) ){
                total_debit = total_debit + double_entry.amount;
            }else if( (double_entry.credited === account_code) || double_entry.credited_parent === account_code ){
                total_credit = total_credit + double_entry.amount;
            }
            if(index === stop_at_index){
                total_obj.total_credit = total_credit;
                total_obj.total_debit = total_debit;
                total_obj.total = total_debit -total_credit;
                return total_obj;
                //return (total_debit - total_credit);
            }
        }
        total_obj.total_credit = total_credit;
        total_obj.total_debit = total_debit;
        total_obj.total = total_debit -total_credit;
        total_obj.calculate_done = true;
        return total_obj;
        //return (total_debit - total_credit);

    }else{

        let total_debit = 0;
        let total_credit = 0;
        let total = 0;
        let total_obj = {
            total_debit: 0,
            total_credit: 0,
            total: 0,
            calculate_done: false
        };
        for (let index = 0; index < transactions.length; index++){
            const double_entry = transactions[index].double_entry;
            if( (double_entry.credited === account_code) || (double_entry.credited_parent===account_code) ){
                total_credit = total_credit + double_entry.amount;
            }else if( (double_entry.debited === account_code) || (double_entry.debited_parent===account_code) ){
                total_debit = total_debit + double_entry.amount;
            }
            if(index === stop_at_index){
                total_obj.total_credit = total_credit;
                total_obj.total_debit = total_debit;
                total_obj.total = total_credit -total_debit;
                return total_obj;
                //return (total_credit - total_debit);
            }
        }
        total_obj.total_credit = total_credit;
        total_obj.total_debit = total_debit;
        total_obj.total = total_credit -total_debit;
        total_obj.calculate_done = true;
        return total_obj;
        //return (total_credit - total_debit);

    }

    
    // if( account_nature===assets_ || account_nature===expense_ ){

    //     //
    //     let the_total = 0;
    //     let total_debit = 0;
    //     let total_credit = 0;
    //     for (let index = 0; index < transactions.length; index++){
    //         //
    //         const element_amount = transactions[index].double_entry.amount;
    //         if(debited_flag){
    //             total_debit = total_debit + element_amount;
    //         }else{
    //             total_credit = total_credit + element_amount;
    //         }
    //     }
    //     return total_credit;

    // }else{



    // }

    // for (let index = 0; index < transactions.length; index++) { //Loop throught provided Transactions
    //     const element_amount = transactions[index].double_entry.amount;

    //     if( account_nature===assets_ || account_nature===expense_ ){
    //         if(debited_flag){
    //             the_total = the_total + element_amount;
    //         }else if(credited_flag){
    //             the_total = the_total - element_amount;
    //         }else{
    //             the_total = the_total + 0;
    //         }
    //     }else{
    //         if(debited_flag){
    //             the_total -= element_amount;
    //         }else if(credited_flag){
    //             the_total += element_amount;
    //         }else{
    //             the_total += 0;
    //         }
    //     }
        
    //     if( index === stop_at_index ){
    //         return the_total;
    //     }
    // }
    //return the_total;
}

export function form_address(address_obj,address_type=ADDRESS_TYPES.BILLING){

    if(address_type === ADDRESS_TYPES.BILLING){
        let supplier_str = address_obj.salutation+' '+
        address_obj.first_name+' '+
        address_obj.last_name+',<br>'+
        address_obj.company.name+',<br>'+address_obj.addresses.billing.address+',<br>'
        +address_obj.addresses.billing.postal_code+' '+address_obj.addresses.billing.city+' '+
        address_obj.addresses.billing.country.name;
        return supplier_str;
    }else{
        let supplier_str = address_obj.salutation+' '+
        address_obj.first_name+' '+
        address_obj.last_name+',<br>'+
        address_obj.company.name+',<br>'+address_obj.addresses.shipping.address+',<br>'
        +address_obj.addresses.shipping.postal_code+' '+address_obj.addresses.shipping.city+' '+
        address_obj.addresses.shipping.country.name;
        return supplier_str;
    }

}

export function getDates(date_form=null){
    let result = null
    if(date_form){
        switch(date_form){
            case "Default Date":
                result = new Date();
            break;
        }
    }else{
        let currentDate = new Date();
        result = new Date().toJSON().slice(0,10).replace(/-/g,'/');
    }
    return result
}

export function handle_requistion_listing(requested_list){

    //let requistion_table = document.getElementById("requistion_table_holder");
    let html_string = '';
    if(requested_list.length > 0){
        html_string += '<thead><tr class="titled"><th colspan="7">Available Requisition List:('+requested_list.length+')</th></tr></thead>';
        html_string += '<tbody>';//open tbody
            for( let k=0; k<requested_list.length;k++ ){
                html_string +='<tr data-toggle="collapse" class="pointer-cursor" data-target="#collapseme_'+k+'">';
                    html_string +='<td colspan="5" class="fs-12 fs-13"><span class="fw-600 fs-14 cl-amref">REQ_NO: #'+requested_list[k].req_no+' '+requested_list[k].trans_date+'</span> | <span class="fw-600 fs-13">Branch:</span> '+requested_list[k].source_facility.facility_name+' | <span class="fw-600 fs-13">Store:</span> '+requested_list[k].source_facility.store.name+' | <span class="fw-600 fs-13">Dep:</span> '+requested_list[k].source_facility.department.name+' | <span class="fw-600 fs-13">Sub-Store:</span> '+requested_list[k].source_facility.sub_store.name+' </td>';
                    let last_status = requested_list[k].movement_status[requested_list[k].movement_status.length-1].status==="Pending";
                    if( last_status==="Pending" ){
                        html_string +='<td><span class="btn-pending">Pending</span></td>';
                    }else if( last_status==="Approved" ){
                        html_string +='<td><span class="btn-approved">Approved</span></td>';
                    }else if( last_status==="Declined" ){
                        html_string +='<td><span class="btn-declined">Declined</span></td>';
                    }else if( last_status==="Shipping" ){
                    }else if( last_status==="Delivered" ){
                    }
                    html_string +='<td style="text-align:right;"><a data-toggle="collapse" class="fs-15 pointer-cursor cl-amref" data-target="#collapseme">+</a></td>';
                html_string +='</tr>'; //end tr

                // --------------------------------------------------------------
                html_string += '<tr class="requistion-holder">'; //start tr
                    html_string+='<td colspan="6" class="zeroPadding">';
                        html_string+='<div class="collapse out width-100-pc padding-20" id="collapseme">';
                            html_string+='<table class="">';
                                html_string+='<thead>';
                                    html_string+='<tr>';
                                        html_string+='<th style="width:12%">Req/No#</th>';
                                        html_string+='<th style="width:15%">Requested/On</th>';
                                        html_string+='<th style="width:30%">Item(s)</th>';
                                        html_string+='<th style="width:12%">Requested/Qty</th>';
                                        html_string+='<th style="width:13%">Qty/On/Hand</th>';
                                        html_string+='<th style="width:15%">Requested/By</th>';
                                        html_string+='<th style="width:3%"></th>';
                                    html_string+='</tr>';
                                html_string+='</thead>';
                            html_string+='</table>';
                        html_string+='</div>';
                    html_string += '</td>';

                html_string += '</tr>'; //end tr
                // --------------------------------------------------------------

            }
        html_string += '</tbody>'; //close tbody
        return html_string;
    }else{
        html_string += '<tbody>'+
                '<tr>'+
                    '<td colspan="7" class="text-center cl-amref fs-14 fw-400">No transaction to display</td>'+
                '</tr>'+
        '</tbody>';
        return html_string;
    }
    

}

export function check_negatives(e){
    if(!((e.keyCode > 95 && e.keyCode < 106)
      || (e.keyCode > 47 && e.keyCode < 58) 
      || e.keyCode == 8)) {
        return false;
    }
}

export function location_obj_setter(initializations,facility=null){

    let stores = [];
    let departments = [];
    let sub_stores = [];

    if(facility){

        for( let k=0; k<initializations.stores.length; k++ ){
            if( initializations.stores[k].facility_id === facility ){
                stores.push(initializations.stores[k]);
            }
        }

        for( let k=0; k<initializations.sub_stores.length; k++ ){
            if( initializations.sub_stores[k].facility_id === facility ){
                sub_stores.push(initializations.sub_stores[k]);
            }
        }

        departments = initializations.departments;

        return {
            departments: departments,
            stores: stores,
            sub_stores: sub_stores,
        }

    }else{
        return {
            departments: [],
            stores: [],
            sub_stores: [],
        }
    }



}

export function create_item(item_product = null){

    let item = {
        //attribute based
        id: '',
        item_name: '',
        generic_name: '',
        sku_code: '',
        barcode: '',
        category: '',
        manufacturer: '',
        profile_name: '',
        brand: '',
        brand_sector: '',
        measure_unit_name: '',
        measure_unit_symbol: '',
        unit_weight: '',
        pack_qty: '',
        reorder_level: '',
        unit_cost: '',
        unit_retail: '',
        pack_cost: '',
        pack_retail: '',
        tax_name: '',
        tax_value: '',
        note: '',
        //stock based
        item_stock: '',
        vendor_item_number: '',
        qty_available: '',
        description: '',
        batch_number: '',
        exp_month: '',
        exp_year: '',
        man_month: '',
        man_year: '',
        status: '',
        practice_product_item_id: '',
        practice_id: '',
        qty: '',
        amount: '',
        description: '',
    };

    //return item;

    if(item_product){
        item = item_product;
        // item.generic_name = item_product.generic_name;
        // item.sku_code = item_product.sku_code;
        // item.item_stock = item_product.item_stock;
        // item.alert_indicator_level = item_product.alert_indicator_level;
        // item.single_unit_weight = item_product.single_unit_weight;

        // item.pack_cost = item_product.pack_cost;
        // item.barcode = item_product.barcode;
        // item.manufacturer = item_product.manufacturer;
        // item.product_type = item_product.product_type;
        // item.product_type = item_product.product_type;
        // item.product_brand = item_product.product_brand;
        // item.brand_sector = item_product.brand_sector;

        // item.pack_retail = item_product.pack_retail_price;
        // item.unit_cost = item_product.unit_cost;
        // item.unit_retail = item_product.unit_retail_price;
        // item.unit_name = item_product.item_name;
        // item.unit_weight = item_product.single_unit_weight;
        // item.unit_measure_type = item_product.product_unit_slug;
        // item.practice_product_item_id = item_product.id;
        // item.units_per_pack = item_product.units_per_pack;
        // item.tax_charges = item_product.tax_charges;

        return item;

    }else{
        return item;
    }

}

export function add_search_item(item_product, item_form){

    let add_item = true;
    for ( let i = 0; i < item_form.items.length; i++ ){
        if (item_form.items[i].id === item_product.id){
            add_item = false;
            break;
        }
    }

    if (add_item){
        let item = create_item(item_product);
        //let item = this.create_item(item_product);
        item_form.items.push(item);
        //item_form.total_bill += item.unit_retail;
        //***item_form.total_bill += item.qty * item.pack_cost;
        if (item_form.discount_offered > 0){
            //****item_form.total_grand = item_form.total_bill - ( (item_form.discount_offered/100)*item_form.total_bill );
        } else {
            //****item_form.total_grand = item_form.total_bill;
        }
    }

    return item_form;

}

export function create_mail_content(subject,subject_obj=null,currency=null){

    let mail_content = {
        send_to: '',
        subject: '',
        cc: '',
        content: '',
        trans_number: '',
        attachment: [],
    };

    let trans_type = '';
    let trans_number = '';
    let ship_to = '';
    let to_name = '';
    let trans_date = '';
    let trans_due_date = '';
    let created_by = '';
    let amount = 0;
    let html_str = '';

    switch (subject) {
        case TRANSACTION_TYPES.PURCHASE_ORDER:
            //------------
            trans_type = TRANSACTION_TYPES.PURCHASE_ORDER;
            trans_number = subject_obj.trans_number;
            ship_to = subject_obj.shipping.name;
            to_name = subject_obj.vendor.legal_name;
            trans_date = subject_obj.po_date;
            trans_due_date = subject_obj.po_due_date;
            created_by = subject_obj.status[subject_obj.status.length-1].signatory.first_name;
            amount = subject_obj.total_bill;
            //---------
            mail_content.send_to = subject_obj.vendor.email;
            mail_content.trans_number = subject_obj.trans_number;
            mail_content.attachment = [
                {
                    type: 'default',
                    name: trans_number,
                }
            ]
            mail_content.subject = trans_type+" from "+ship_to+" ("+trans_type+"#: "+trans_number+")";
            html_str = '<h5>Dear '+to_name+',\n\n';
                html_str += 'The '+trans_type+' ('+trans_number+') is attached with this email.\n\n';
                html_str += 'An overview of the '+trans_type+' is available below:\n\n';
                html_str += '</h5>';
                html_str += '-----------------------------------------------------\n\n';
                html_str += '<h4><b>'+trans_type+' #: '+trans_number+'</b></h4>\n';
                html_str += '-----------------------------------------------------\n';
                html_str += '<h5><b>Date: </b> '+trans_date+'</h5>\n';
                html_str += '<h5><b>Due Date: </b>   '+trans_due_date+'</h5>\n';
                html_str += '<h5><b>Amount: </b>     '+currency+' '+formatMoney(amount)+'</h5>';
                html_str += '-----------------------------------------------------\n';
                html_str += '<h5>Please go through it and confirm the order. We look forward to working with you again</h5>\n';
                html_str += '<h5>Regards,</h5>\n';
                html_str += '<h5>'+created_by+'</h5>';
                mail_content.content = html_str;
                return mail_content;
            break;
        case TRANSACTION_TYPES.BILL:
            //---------
            trans_number = subject_obj.trans_number;
            trans_type = TRANSACTION_TYPES.BILL;
            trans_date = subject_obj.bill_date;
            trans_due_date = subject_obj.bill_due_date;
            amount = subject_obj.net_total;
            mail_content.send_to = subject_obj.vendor.email;
            mail_content.trans_number = subject_obj.trans_number;
            created_by = subject_obj.status[subject_obj.status.length-1].signatory.first_name;
            mail_content.attachment = [
                {
                    type: 'default',
                    name: trans_number,
                }
            ];
            mail_content.subject = trans_type+" from "+ship_to+" ("+trans_type+"#: "+trans_number+")";
            html_str = '<h5>Dear '+to_name+',\n\n';
                html_str += 'The '+trans_type+' ('+trans_number+') is attached with this email.\n\n';
                html_str += 'An overview of the '+trans_type+' is available below:\n\n';
                html_str += '</h5>';
                html_str += '-----------------------------------------------------\n\n';
                html_str += '<h4><b>'+trans_type+' #: '+trans_number+'</b></h4>\n';
                html_str += '-----------------------------------------------------\n';
                html_str += '<h5><b>Order Date: </b> '+trans_date+'</h5>\n';
                html_str += '<h5><b>Due Date: </b>   '+trans_due_date+'</h5>\n';
                html_str += '<h5><b>Amount: </b>     '+currency+' '+formatMoney(amount)+'</h5>';
                html_str += '-----------------------------------------------------\n';
                html_str += '<h5>Please go through it and confirm.</h5>\n';
                html_str += '<h5>Regards,</h5>\n';
                html_str += '<h5>'+created_by+'</h5>';
                mail_content.content = html_str;
                return mail_content;
            break;
        case TRANSACTION_TYPES.SUPPLIER_PAYMENTS:
            //trans_number = subject_obj.bills[0].trans_number;
            trans_type = TRANSACTION_TYPES.SUPPLIER_PAYMENTS;
            to_name = subject_obj.vendor.legal_name;
            trans_date = subject_obj.payment_date;
            amount = subject_obj.amount;
            mail_content.send_to = subject_obj.vendor.email;
            mail_content.trans_number = subject_obj.trans_number;
            //created_by = subject_obj.status[subject_obj.status.length-1].signatory.first_name;
            let trans_array = [];
            for (let index = 0; index < subject_obj.bills.length; index++) {
                const element = subject_obj.bills[index];
                let eleme={
                    type: 'default',
                    name: element.trans_number,
                }
                trans_array.push(element.trans_number);
                mail_content.attachment.push(eleme);
            }
            trans_number = trans_array.toString();

            mail_content.subject = "Payment has been made for your invoice(s)";
            html_str = '<h5>Hi '+to_name+',\n\n';
                html_str += 'We have made the payment for your invoice(s). Its been a pleasure doing business .\n\n';
                html_str += 'with you. We look forward to working with you again.';
                html_str += '</h5>';
                html_str += '-----------------------------------------------------\n';
                html_str += '<h5><b>Date: </b> '+trans_date+'</h5>\n';
                html_str += '<h5><b>Invoice Number: </b> '+trans_number+'</h5>\n';
                html_str += '<h5><b>Amount: </b>     '+currency+' '+formatMoney(amount)+'</h5>';
                html_str += '-----------------------------------------------------\n';
                html_str += '<h5>Regards,</h5>\n';
                html_str += '<h5>'+created_by+'</h5>';
                mail_content.content = html_str;
                return mail_content;
            break;
        case TRANSACTION_TYPES.SUPPLIER.PURCHASE_RETURN:
            trans_type = TRANSACTION_TYPES.SUPPLIER.PURCHASE_RETURN;
            to_name = subject_obj.vendor.legal_name;
            trans_date = subject_obj.return_date;
            amount = subject_obj.net_total;
            mail_content.send_to = subject_obj.vendor.email;
            mail_content.trans_number = subject_obj.trans_number;
            mail_content.subject = "Return has been made for your invoice(s)";
            html_str = '<h5>Hi '+to_name+',\n\n';
                html_str += 'We have made the purchase return for your invoice(s).\n\n';
                html_str += 'An overview of the '+trans_type+' is available below:\n\n';
                html_str += '</h5>';
                html_str += '-----------------------------------------------------\n';
                html_str += '<h5><b>Date: </b> '+trans_date+'</h5>\n';
                html_str += '<h5><b>Invoice Number: </b> '+trans_number+'</h5>\n';
                html_str += '<h5><b>Amount: </b>     '+currency+' '+formatMoney(amount)+'</h5>';
                html_str += '-----------------------------------------------------\n';
                html_str += '<h5>Please go through it and confirm.</h5>\n';
                html_str += '<h5>Regards,</h5>\n';
                html_str += '<h5>'+created_by+'</h5>';
                mail_content.content = html_str;
                return mail_content;
            break;
        default:
            return mail_content;
            break;
    }

}

export function amend_totals(event,type_,unit_cost,pack_cost,product_id,index,item_form,price_mode=null,taxations=[]){

    //WARNING! When looping inside this function don't use "index"
    switch (type_) {
        
        case "qty":
            // if(item_form.items[index].qty===""){
            //     item_form.items[index].amount = 0 * item_form.items[index].pack_cost;
            // }else{
            //     item_form.items[index].amount = item_form.items[index].qty * item_form.items[index].pack_cost;
            // }
        case "pack_cost":
            item_form.items[index].amount = item_form.items[index].qty * item_form.items[index].price.pack_cost;
            break;
        case "cash_paid":
            item_form.payment.cash_balance = item_form.net_total - item_form.payment.cash_paid;
            return item_form;
            break;
        case "invoice_cash_paid"://Recording Customer
            let total_alloc = item_form.payment.total_allocation;
            let am_paid = item_form.payment.cash_paid;
            let am_used = item_form.payment.cash_used;
            let am_refund = item_form.payment.cash_refunded;
            if( (am_paid>0) && (total_alloc<=am_paid) ){
                item_form.payment.cash_used = total_alloc;
                item_form.payment.cash_unlocated = am_paid - total_alloc - am_refund;
            }else if( (am_paid>0) && (total_alloc>am_paid) ){
                item_form.payment.cash_used = am_paid;
                item_form.payment.cash_unlocated = 0;
            }
            //item_form.payment.cash_unlocated = am_paid - am_used - am_refund;
            return item_form;

            break;
        case "remove":
            item_form.items = removeElement(item_form.items, item_form.items[index]);
            break;
    }

    //item_form.total_bill = 0;
    let disc_allowed = 0;
    let line_tax = 0;
    item_form.total_tax = 0;
    item_form.payment.cash_paid = 0;
    item_form.total_discount = 0;
    item_form.grand_total = 0;
    item_form.net_total = 0;

    for ( let i = 0; i < item_form.items.length; i++ ){

        disc_allowed = 0;
        line_tax = 0
        if(price_mode && (price_mode==="wholesale") ){
            //item_form.total_bill += item_form.items[i].qty * item_form.items[i].price.pack_retail_price;
            item_form.items[i].amount = item_form.items[i].qty * item_form.items[i].price.pack_retail_price;
            //discount_allowed
            let total_without_disc = item_form.items[i].qty * item_form.items[i].price.pack_retail_price;
            if(item_form.items[i].discount_rate > 0){
                if(item_form.overal_discount===true){
                    disc_allowed = 0;
                }else{
                    disc_allowed = (item_form.items[i].discount_rate/100) * total_without_disc;
                }
            }
            //Here also calculate taxation
            if(item_form.items[i].applied_tax_rates.length && item_form.taxation_option==='Inclusive of Tax'){
                //console.info(item_form.items[i].applied_tax_rates.length);
                let taxed = [];
                let price_taxed = {
                    pack_bp: item_form.items[i].price.pack_cost,
                    pack_sp: item_form.items[i].price.pack_retail_price,
                    unit_bp: item_form.items[i].price.unit_cost,
                    unit_sp: item_form.items[i].price.unit_retail_price,
                };
                //Tax applicable on a given item
                let appl_tax = item_form.items[i].applied_tax_rates;
                for (let tx = 0; tx < appl_tax.length; tx++) {
                    const element = appl_tax[tx];
                    for (let a = 0; a < taxations.length; a++) {
                        const taxatio = taxations[a];
                        if(taxatio.id === element ){
                            taxed.push(taxatio);
                        }
                    }
                }
                //console.info(taxed);
                const price_after_tx = taxation_calculator(price_taxed,taxed);
                //console.info(price_after_tx);
                //Update "price_after_tax"
                item_form.items[i].price_after_tax.pack_cost = price_after_tx.pack_bp;
                item_form.items[i].price_after_tax.pack_retail_price = price_after_tx.pack_sp;
                item_form.items[i].price_after_tax.unit_cost = price_after_tx.unit_bp;
                item_form.items[i].price_after_tax.unit_retail_price = price_after_tx.unit_sp;
                //console.info(item_form.items);
                let total_after_tax = item_form.items[i].qty * item_form.items[i].price_after_tax.pack_retail_price;
                line_tax = total_without_disc - total_after_tax;
            }else{
                item_form.total_bill += item_form.items[i].qty * item_form.items[i].price.pack_retail_price;
                item_form.items[i].amount = item_form.items[i].qty * item_form.items[i].price.pack_retail_price;
                //discount_allowed
                let disc_allowed = item_form.items[i].qty * item_form.items[i].price.pack_retail_price;
                //sub_stock_total
                item_form.items[i].sub_stock_total = item_form.items[i].qty * item_form.items[i].price.pack_retail_price;
            }

            // console.info(item_form.items)
            //let disc_allowed = item_form.items[i].qty * item_form.items[i].pack_retail;
            //sub_stock_total
            //item_form.items[i].amount = total_without_disc - disc_allowed;
            // item_form.items[i].amount = total_without_disc;
            // item_form.items[i].sub_stock_total = total_without_disc - disc_allowed;
            // //item_form.discount_offered += disc_allowed;
            // item_form.discount_offered += disc_allowed;

            //sub_stock_total
            item_form.items[i].line_discount = disc_allowed;
            item_form.items[i].amount = total_without_disc;
            item_form.items[i].sub_stock_total = total_without_disc - disc_allowed;
            //item_form.discount_offered += disc_allowed;
            //item_form.total_discount += item_form.items[i].line_discount;
            item_form.items[i].line_taxation = line_tax;
            item_form.items[i].line_exclusive = total_without_disc - line_tax;
            item_form.items[i].line_total = total_without_disc - disc_allowed;

        }else if( price_mode && (price_mode==="purchase") ){

            //item_form.total_bill += item_form.items[i].qty * item_form.items[i].price.pack_retail_price;
            item_form.items[i].amount = item_form.items[i].qty * item_form.items[i].price.pack_cost;
            //discount_allowed
            let total_without_disc = item_form.items[i].qty * item_form.items[i].price.pack_cost;
            if(item_form.items[i].discount_rate > 0){
                if(item_form.overal_discount){
                    disc_allowed = 0;
                }else{
                    disc_allowed = (item_form.items[i].discount_rate/100) * total_without_disc;
                }
            }
            //Here you also calculate Taxation
            if(item_form.items[i].applied_tax_rates.length && item_form.taxation_option==='Inclusive of Tax'){
                //console.info(item_form.items[i].applied_tax_rates.length);
                let taxed = [];
                let price_taxed = {
                    pack_bp: item_form.items[i].price.pack_cost,
                    pack_sp: item_form.items[i].price.pack_retail_price,
                    unit_bp: item_form.items[i].price.unit_cost,
                    unit_sp: item_form.items[i].price.unit_retail_price,
                };
                //Tax applicable on a given item
                let appl_tax = item_form.items[i].applied_tax_rates;
                for (let tx = 0; tx < appl_tax.length; tx++) {
                    const element = appl_tax[tx];
                    for (let a = 0; a < taxations.length; a++) {
                        const taxatio = taxations[a];
                        if(taxatio.id === element ){
                            taxed.push(taxatio);
                        }
                    }
                }
                //console.info(taxed);
                const price_after_tx = taxation_calculator(price_taxed,taxed);
                //console.info(price_after_tx);
                //Update "price_after_tax"
                item_form.items[i].price_after_tax.pack_cost = price_after_tx.pack_bp;
                item_form.items[i].price_after_tax.pack_retail_price = price_after_tx.pack_sp;
                item_form.items[i].price_after_tax.unit_cost = price_after_tx.unit_bp;
                item_form.items[i].price_after_tax.unit_retail_price = price_after_tx.unit_sp;
                //console.info(item_form.items);
                let total_after_tax = item_form.items[i].qty * item_form.items[i].price_after_tax.pack_cost;
                line_tax = total_without_disc - total_after_tax;
            }else{
                item_form.total_bill += item_form.items[i].qty * item_form.items[i].price.pack_cost;
                item_form.items[i].amount = item_form.items[i].qty * item_form.items[i].price.pack_cost;
                //discount_allowed
                let disc_allowed = item_form.items[i].qty * item_form.items[i].price.pack_cost;
                //sub_stock_total
                item_form.items[i].sub_stock_total = item_form.items[i].qty * item_form.items[i].price.pack_cost;
            }

            //let disc_allowed = item_form.items[i].qty * item_form.items[i].pack_retail;
            //sub_stock_total
            item_form.items[i].line_discount = disc_allowed;
            item_form.items[i].amount = total_without_disc;
            item_form.items[i].sub_stock_total = total_without_disc - disc_allowed;
            //item_form.discount_offered += disc_allowed;
            //item_form.total_discount += item_form.items[i].line_discount;
            item_form.items[i].line_taxation = line_tax;
            item_form.items[i].line_exclusive = total_without_disc - line_tax;
            item_form.items[i].line_total = total_without_disc - disc_allowed;
        }
        else{
            item_form.total_bill += item_form.items[i].qty * item_form.items[i].price.pack_cost;
            item_form.items[i].amount = item_form.items[i].qty * item_form.items[i].price.pack_cost;
            //discount_allowed
            let disc_allowed = item_form.items[i].qty * item_form.items[i].price.pack_cost;
            //sub_stock_total
            item_form.items[i].sub_stock_total = item_form.items[i].qty * item_form.items[i].price.pack_qty;
        }

        //item_form.total_grand += item_form.items[i].amount;
        //item_form.total_bill += item_form.items[i].line_total;
        item_form.total_tax += item_form.items[i].line_taxation;
        item_form.grand_total += item_form.items[i].amount;
        item_form.net_total += item_form.items[i].amount - item_form.items[i].line_discount;
        item_form.payment.cash_paid = item_form.net_total ;
        item_form.payment.cash_balance = item_form.net_total - item_form.payment.cash_paid;
        item_form.total_discount += (item_form.items[i].amount - item_form.items[i].sub_stock_total);
    }

    if(item_form.overal_discount){
        if( (item_form.overal_discount_rate) && (item_form.overal_discount_rate>0) ){
            item_form.total_discount = (item_form.overal_discount_rate/100) * item_form.grand_total;
            item_form.net_total = item_form.grand_total - item_form.total_discount;
        }
    }

    item_form.sub_total = item_form.net_total - item_form.total_tax;

    return item_form;

}

export function taxation_calculator(prices=null,applied_tax=[]){

    // pack_bp: item_form.items[i].price.pack_cost,
    // pack_sp: item_form.items[i].price.pack_retail_price,
    // unit_pb: item_form.items[i].price.unit_cost,
    // unit_sp: item_form.items[i].price.unit_retail_price,

    if( prices && applied_tax.length ){

        let pack_b_p = prices.pack_bp;
        let pack_s_p = prices.pack_sp;

        let unit_b_p = prices.unit_bp;
        let unit_s_p = prices.unit_sp;

        for (let t = 0; t < applied_tax.length; t++) {

            const applied = applied_tax[t];
            //Taxations collected on sales
            //&& 
            if(applied.collected_on_sales){
                //Sales:
                //1. Wholesale
                if(applied.sales_rate > 0){
                    let pack_sp_tax = (applied.sales_rate/100) * prices.pack_sp;
                    pack_s_p -= pack_sp_tax;
                    //2. Retail
                    let unit_sp_tax = (applied.sales_rate/100) * prices.unit_sp;
                    unit_s_p -= unit_sp_tax;
                }

            }
            
            //Collected on Purchases
            //&& applied.purchase_rate
            if(applied.collected_on_purchase){
                //Purchases:
                //1. Wholesale
                if(applied.purchase_rate > 0){

                    let pack_bp_tax = (applied.purchase_rate/100) * prices.pack_bp;
                    pack_b_p -= pack_bp_tax;
                    //
                    let unit_bp_tax = (applied.purchase_rate/100) * prices.unit_bp;
                    unit_b_p -= unit_bp_tax;

                }

            }
        }

        prices.pack_bp = pack_b_p;
        prices.pack_sp = pack_s_p;
        prices.unit_bp = unit_b_p;
        prices.unit_sp = unit_s_p;
        return prices;

    }else{
        return prices;
    }

}

export function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}

export function calculation_handler(calc_type,qty=null,pack_qty=null){

    switch(calc_type){
        case "packs":
            return Math.round( (qty/pack_qty) );
            break;
        case "units":
            return Math.round( (qty%pack_qty) );
            break;
        case "total_stock":
            //console.info(qty);
            return qty.reduce((acc, val) => {
                return acc + parseInt(val.qty);
                }, 0);
            break;
    }
}

export function exportToCsv(data_to_export,file_name){

    const options = {
        fieldSeparator: ',',
        filename: file_name,
        quoteStrings: '"',
        decimalSeparator: '.',
        showLabels: true,
        showTitle: false,
        title: 'CSV TEST',
        useTextFile: false,
        useBom: true,
        useKeysAsHeaders: true,
    };
    const csvExporter = new ExportToCsv(options);
    csvExporter.generateCsv(data_to_export);
}

export function removeElement(array_to,element_to) {
    let index = array_to.indexOf(element_to);
    if (index !== -1) { array_to.splice(index, 1); }
    return array_to;
}

export function removeIndex(array_to,index_to) {
    if(index_to > -1){
        return array_to.splice(index_to, 1);
    }else{
        return array_to
    }
}

export function isInArray(value, array) {
    return array.includes(value);
}

export function getYear() {
    return moment(String(value)).format('MM/DD/YYYY hh:mm')
}

export function createHtmlErrorString(errors = []) {

    let html_errors = '<ul>';

    for (let ki = 0; ki < errors.length; ki++ ) {

        html_errors += '<li>'+errors[ki]+'</li>';

    }

    html_errors += '</ul>';

    return html_errors;

}

export function reset_forms(form_object){
    for( let key in form_object){
        //console.info(key);
        if( key==="type" || key==="id" || key==="as_of" || key==="as_at" || key === "practice_id" || key==="facility_id" || key==="mail_invitation" || key==="action_taken"){
            
        }else if(key==="is_sub_account"){
            form_object[key] = false;
        }
        else if(Array.isArray(key)){
            form_object[key] = [];
        }
        else{
            form_object[key] = null;
        }
    }
    return form_object;
}

export function print_divs(divName) {
    let printContents = document.getElementById(divName).innerHTML;
    let originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}

export function reset_form_inputs(obj_given) {

}

export function customizeLoader(action) {
    if (action === 'show') {
        return {
            is_active: true,
            opacity: 0,
            height: 3,
            width: 3,
        }
    }else {
        return {
            is_active: false,
            opacity: 0,
            height: 3,
            width: 3,
        }
    }

}

export function sleep(milliseconds) {
    let start = new Date().getTime();
    for (let i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}

export function getUuidService() {
    return localStorage.getItem('service_id');
}

export function storeUuidService(payload) {
    localStorage.setItem('service_id',payload);
}

export function deleteUuidService() {
    localStorage.removeItem('service_id');
}

export function navLinkActiveness(target = null) {

    if (target) {

        return {
            details: false,
            staff: false,
            schedules: false,
            notification: false,
            pricing: false,
            security: false,
            clinical: false,
            drugcatalogue: false,
            printouts: false,
            emails: false,
            billings: false,
            autoid: false,
            groups: false,
        }

    }

    return {
        records: false,
        appointments: false,
        tests: false,
        orders: false,
        consultation: false,
        chats: false,
        calls: false,
        articles: false,
        feedback: false,
        payments: false,
    }

}

export function get_ledger_totals(nature_type,ledgers,last_index=0){
    const assets_ = ACCOUNTING.ACCOUNT_NATURES.ASSETS;
    const expense_ = ACCOUNTING.ACCOUNT_NATURES.EXPENSE;
    const liability_ = ACCOUNTING.ACCOUNT_NATURES.LIABILITY;
    const revenue_ = ACCOUNTING.ACCOUNT_NATURES.REVENUE;
    const equity_ = ACCOUNTING.ACCOUNT_NATURES.EQUITY;
    let result = 0;
    switch (nature_type) {
        case assets_:
        case expense_:
            for (let index = 0; index < ledgers.length; index++) {
                const ledger = ledgers[index];
                //console.info(ledger);
                //Check if this transaction had a normal debit balances
                if(ledger.debit.account_nature.name === assets_ || ledger.debit.account_nature.name === expense_){
                    result += ledger.debit.amount;
                }else if( ledger.credit.account_nature.name===assets_ || ledger.debit.account_nature.name===expense_){
                    result -= ledger.credit.amount;
                }
                // if(ledger.debit.account_nature.name === assets_ || ledger.debit.account_nature.name === expense_){
                //     result += ledger.debit.amount;
                // }else if( ledger.debit.account_nature.name===liability_ || ledger.debit.account_nature.name===revenue_ || ledger.debit.account_nature.name===equity_){
                //     result -+ ledger.debit.amount;
                // }

                if( (last_index !== -1) && index === last_index){
                    break;
                }
            }
            break;
    
        case liability_:
        case revenue_:
        case equity_:
            for (let index = 0; index < ledgers.length; index++) {
                const ledger = ledgers[index];
                const debited = ledger.debit;
                const credited = ledger.credit;
                //Check if this transaction have credit balances,
                if( ledger.credit.account_nature.name===liability_ || ledger.credit.account_nature.name===revenue_ || ledger.credit.account_nature.name===equity_ ){
                    result += ledger.credit.amount;
                }
                
                if(debited.account_nature.name === liability_ || ledger.debit.account_nature.name === revenue_ || ledger.debit.account_nature.name === equity_ ){
                    result -= ledger.debit.amount;
                }

                // if( ledger.credit.account_nature.name===liability_ || ledger.credit.account_nature.name===revenue_ || ledger.credit.account_nature.name===equity_ ){
                //     result += ledger.credit.amount;
                // }else if(ledger.debit.account_nature.name === assets_ || ledger.debit.account_nature.name === expense_){
                //     result -= ledger.credit.amount;
                // }
                if( (last_index !== -1) && index === last_index){
                    break;
                }
            }
            break;
    }
    return result;
}

export function create_bank_statement_transaction(statement=null,today_date=null){

    if(today_date){
        today_date = format_lunox_date(today_date);
    }

    if(statement){
        statement.transaction_date = format_lunox_date(statement.transaction_date);
        return statement;
    }else{
        return {
            id: null,
            transaction_date: today_date,
            payee: null,
            description: null,
            type: null,
            discount: null,
            comment: null,
            selection: null,
            reference: null,
            vat: null,
            spent: null,
            received: null,
            reconciled: false,
            error: false,
            rec: false,
            error_msg: null,
            selections: []
        }
    }

}



export function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
    try {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
    } catch (e) {
        console.log(e)
    }
}

export function customClasses() {

    return {
        header_sticky: true,
        sticky: true,
        'mt-40': false,
        menu_header: true,
    }

}

// moment().format('MMMM Do YYYY, h:mm:ss a'); // February 11th 2019, 11:15:35 am
// moment().format('dddd');                    // Monday
// moment().format("MMM Do YY");               // Feb 11th 19
// moment().format('YYYY [escaped] YYYY');     // 2019 escaped 2019
// moment().format();                          // 2019-02-11T11:15:35+03:00

