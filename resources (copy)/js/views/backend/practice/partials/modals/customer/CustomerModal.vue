<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content bg-ced">

                <div class="modal-header">
                    <h4 class="width-100-pc text-left fs-19"> {{title}}</h4>
                </div>

                <div class="modal-body padding-bottom-29">
                    <div class="width-100-pc float-left mg-top-20 padding-right-15 padding-left-15">
                        <div class="width-45-pc float-left">
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-40-pc">
                                    <label class="company-label text-right">Salute:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-60-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <select v-model="form.salutation" v-bind:class="{'height-32':true,'custom-attended-field':form.salutation}">
                                            <option>-select-</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Miss">Dr</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-40-pc">
                                    <label class="company-label text-right">First Name:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-60-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.first_name" required v-bind:class="{'height-32':true,'custom-attended-field':form.first_name}" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-40-pc">
                                    <label class="company-label text-right">Last Name:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-60-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.last_name" required v-bind:class="{'height-32':true,'custom-attended-field':form.last_name}" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-40-pc">
                                    <label class="company-label text-right">Category:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-60-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <select v-model="form.category" v-bind:class="{'height-32':true,'custom-attended-field':form.category}">
                                            <option>-select-</option>
                                            <option value="Local">Local</option>
                                            <option value="International">International</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-40-pc">
                                    <label class="company-label text-right fs-12">VAT Reference:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-60-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.tax_reg_number" v-bind:class="{'height-32':true,'custom-attended-field':form.tax_reg_number}" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="width-45-pc float-left">
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-40-pc">
                                    <label class="company-label text-right fs-12">Active:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-60-pc">
                                    <label class="check-container small element-inlined fs-12 role-label-fw-normal width-100-pc mg-right-10">
                                        <input v-model="form.status" type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-40-pc">
                                    <label class="company-label text-right">Credit Limit:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-60-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.credit_limit" @keyup="reject_negatives($event)" v-bind:class="{'height-32':true,'custom-attended-field':form.credit_limit}" step="any" type="number">
                                    </div>
                                </div>
                            </div>
                            <div v-if="user_mode==='Create'" class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-40-pc">
                                    <label class="company-label text-right">Opening Balance:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-60-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.opening_balance" @keyup="reject_negatives($event)" v-bind:class="{'height-32':true,'custom-attended-field':form.opening_balance}" type="number">
                                    </div>
                                </div>
                            </div>
                            <div v-if="user_mode==='Create'" class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-40-pc">
                                    <label class="company-label text-right">Opening Balance as At:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-60-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <datetime 
                                            v-model="form.as_of"
                                            :input-id="'date_input_'"
                                            placeholder="select date"
                                            use12-hour
                                            :type="'date'"
                                            :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                            :value="form.as_of"
                                            >
                                        </datetime>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="row fullName mg-bottom-5 mg-left-30 mg-top-30">
                                <div class="inlineBlock width-40-pc">
                                    <label class="company-label text-right">Balance:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-60-pc">
                                    {{currency+' '+format_money(form.balance)}}
                                </div>
                            </div>
                        </div>

                        <div class="width-100-pc float-left mg-top-30">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a @click="toggleTab(0)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===0}" :id="'nav-transactions-tab-'+'0'" data-toggle="tab" :href="'#nav-transactions-'+'0'" role="tab" :aria-controls="'nav-transactions-'+'0'" aria-selected="true" :key="'transactions_tab'+'0'">Details</a>
                                    <a @click="toggleTab(1)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Address</a>
                                    <a @click="toggleTab(2)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===2}" :id="'nav-transactions-tab-'+'2'" data-toggle="tab" :href="'#nav-transactions-'+'2'" role="tab" :aria-controls="'nav-transactions-'+'2'" aria-selected="true" :key="'transactions_tab'+'2'">Notes</a>
                                    <a @click="toggleTab(3)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===3}" :id="'nav-transactions-tab-'+'3'" data-toggle="tab" :href="'#nav-transactions-'+'3'" role="tab" :aria-controls="'nav-transactions-'+'3'" aria-selected="true" :key="'transactions_tab'+'3'">Payment&Billing</a>
                                    <a @click="toggleTab(4)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===4}" :id="'nav-transactions-tab-'+'4'" data-toggle="tab" :href="'#nav-transactions-'+'4'" role="tab" :aria-controls="'nav-transactions-'+'4'" aria-selected="true" :key="'transactions_tab'+'4'">Attachments</a>
                                </div>
                            </nav>
                            <div class="tab-content tab-content-role" id="nav-tabContent">
                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===0}" :id="'nav-transactions-'+'0'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'0'" :key="'tab_index_'+'0'">
                                    <!-- Tab 1 -->
                                    <div class="width-100-pc float-left padding-left-15 padding-right-15 bg-f4 padding-bottom-20">
                                        <!-- Tab 1 Contact Details -->
                                        <div class="width-45-pc float-left mg-top-20">
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-100-pc">
                                                    <label class="fullname fw-600 fs-14">Contact Details</label>
                                                </div>
                                            </div>
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-40-pc">
                                                    <label class="company-label text-right">Contact Name:&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="inlineBlock width-60-pc">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <input v-model="form.legal_name" required v-bind:class="{'height-32':true,'custom-attended-field':form.legal_name}" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-40-pc">
                                                    <label class="company-label text-right">Email:&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="inlineBlock width-60-pc">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <input v-model="form.email" required v-bind:class="{'height-32':true,'custom-attended-field':form.email}" type="email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-40-pc">
                                                    <label class="company-label text-right">Telephone:&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="inlineBlock width-60-pc">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <input v-model="form.phone" required v-bind:class="{'height-32':true,'custom-attended-field':form.phone}" type="number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-40-pc">
                                                    <label class="company-label text-right">Mobile:&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="inlineBlock width-60-pc">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <input v-model="form.mobile" required v-bind:class="{'height-32':true,'custom-attended-field':form.mobile}" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-40-pc">
                                                    <label class="company-label text-right">Fax:&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="inlineBlock width-60-pc">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <input v-model="form.fax" v-bind:class="{'height-32':true,'custom-attended-field':form.fax}" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-40-pc">
                                                    <label class="company-label text-right">Website:&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="inlineBlock width-60-pc">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <input v-model="form.website" v-bind:class="{'height-32':true,'custom-attended-field':form.website}" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tab 1 -->
                                </div>
                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===1}" :id="'nav-transactions-'+'1'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'1'" :key="'tab_index_'+'1'">
                                    <div class="width-100-pc float-left padding-left-15 padding-right-15 bg-f4 padding-bottom-20">
                                        <div class="width-45-pc float-left mg-top-20">
                                            <div class="width-100-pc float-left fullName mg-bottom-10">
                                                <div class="width-100-pc float-left">
                                                    <label class="fullname fw-600 fs-14">Billing Address</label>
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <textarea v-model="billing.address" required placeholder="Address" v-bind:class="{'min-height-60':true,'custom-attended-field':billing.address}"></textarea>
                                                    </div>
                                                </div>
                                                <div class="width-50-pc float-left mg-top-4 padding-right-3">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc"  role="presentation" >
                                                        <input v-model="billing.city" v-bind:class="{'height-32':true,'custom-attended-field':billing.city}" placeholder="City/Town/County" required type="text">
                                                    </div>
                                                </div>
                                                <div class="width-50-pc float-left mg-top-4">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <input v-model="billing.region" v-bind:class="{'height-32':true,'custom-attended-field':billing.region}" placeholder="Region/Province" type="text">
                                                    </div>
                                                </div>
                                                <div class="width-50-pc float-left mg-top-4 padding-right-3">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <input v-model="billing.postal_code" v-bind:class="{'height-32':true,'custom-attended-field':billing.postal_code}" placeholder="Postal code" type="text">
                                                    </div>
                                                </div>
                                                <div class="float-left width-50-pc mg-top-4">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <vue-single-select
                                                            name="maybe"
                                                            placeholder="Country"
                                                            you-want-to-select-a-post="ok"
                                                            v-model="billing.country"
                                                            out-of-all-these-posts="makes sense"
                                                            :options="countries"
                                                            a-post-has-an-id="good"
                                                            the-post-has-a-title="make"
                                                            option-label="name"
                                                        ></vue-single-select>
                                                    </div>
                                                </div>
                                                <div class="float-left width-100-pc mg-top-4">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <input placeholder="Zip Code" v-model="billing.zip_code" v-bind:class="{'height-32':true,'custom-attended-field':billing.zip_code}" type="text">
                                                    </div>
                                                </div>
                                                <div class="float-left width-50-pc mg-top-4 padding-right-3">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <input placeholder="Phone" v-model="billing.phone" v-bind:class="{'height-32':true,'custom-attended-field':billing.phone}" type="text">
                                                    </div>
                                                </div>
                                                <div class="float-left width-50-pc mg-top-4">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <input placeholder="Fax" v-model="billing.fax" v-bind:class="{'height-32':true,'custom-attended-field':billing.fax}" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width-45-pc float-left mg-top-20 mg-left-20">
                                            <div class="width-100-pc float-left fullName mg-bottom-10">
                                                <div class="float-left width-100-pc">
                                                    <label class="fullname fw-600 fs-14">Shipping Address&nbsp;&nbsp;&nbsp;<a @click="copy_address" class="float-right cl-blue-link"><i class="fa fa-arrow-down"></i> copy billing address</a></label>
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <textarea v-model="shipping.address" required placeholder="Address" v-bind:class="{'min-height-60':true,'custom-attended-field':shipping.address}"></textarea>
                                                    </div>
                                                </div>
                                                <div class="float-left width-50-pc mg-top-4 padding-right-3">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc"  role="presentation" >
                                                        <input v-model="shipping.city" v-bind:class="{'height-32':true,'custom-attended-field':shipping.city}" placeholder="City/Town/County" required type="text">
                                                    </div>
                                                </div>
                                                <div class="float-left width-50-pc mg-top-4">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <input v-model="shipping.region" v-bind:class="{'height-32':true,'custom-attended-field':shipping.region}" placeholder="Region/Province" type="text">
                                                    </div>
                                                </div>
                                                <div class="float-left width-50-pc mg-top-4 padding-right-3">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <input v-model="shipping.postal_code" v-bind:class="{'height-32':true,'custom-attended-field':shipping.postal_code}" placeholder="Postal code" type="text">
                                                    </div>
                                                </div>
                                                <div class="float-left width-50-pc mg-top-4">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <vue-single-select
                                                            name="maybe"
                                                            placeholder="Country"
                                                            you-want-to-select-a-post="ok"
                                                            v-model="shipping.country"
                                                            out-of-all-these-posts="makes sense"
                                                            :options="countries"
                                                            a-post-has-an-id="good"
                                                            the-post-has-a-title="make"
                                                            option-label="name"
                                                        ></vue-single-select>
                                                    </div>
                                                </div>
                                                <div class="float-left width-100-pc mg-top-4">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <input placeholder="Zip Code" v-model="shipping.zip_code" v-bind:class="{'height-32':true,'custom-attended-field':shipping.zip_code}" type="text">
                                                    </div>
                                                </div>
                                                <div class="float-left width-50-pc mg-top-4 padding-right-3">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <input placeholder="Phone" v-model="shipping.phone" v-bind:class="{'height-32':true,'custom-attended-field':shipping.phone}" type="text">
                                                    </div>
                                                </div>
                                                <div class="float-left width-50-pc mg-top-4">
                                                    <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                        <input placeholder="Fax" v-model="shipping.fax" v-bind:class="{'height-32':true,'custom-attended-field':shipping.fax}" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===2}" :id="'nav-transactions-'+'2'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'2'" :key="'tab_index_'+'2'">
                                    <div class="width-100-pc padding-left-15 padding-right-15 float-left bg-f4 padding-bottom-20">
                                        <div class="width-100-pc float-left mg-top-20">
                                            <div class="width-100-pc float-left fullName mg-bottom-10">
                                                <div class="width-100-pc float-left">
                                                    <label class="fullname fw-600 fs-14">Notes</label>
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <textarea v-model="form.notes" required v-bind:class="{'min-height-120':true,'custom-attended-field':form.notes}"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===3}" :id="'nav-transactions-'+'3'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'3'" :key="'tab_index_'+'3'">
                                    <!-- -------------------Payment & Billings Starts Here------------ -->
                                    <div class="width-100-pc padding-left-15 padding-right-15 float-left bg-f4 padding-bottom-20">
                                        <div class="width-45-pc float-left mg-top-20">
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-100-pc">
                                                    <label class="fullname fw-600 fs-14">Payment&Billing</label>
                                                </div>
                                            </div>
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-40-pc">
                                                    <label class="company-label text-right fs-12">Default Discount:&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="inlineBlock width-60-pc">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <input v-model="form.default_discount" @keyup="reject_negatives($event)" v-bind:class="{'height-32':true,'custom-attended-field':form.default_discount}" type="number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-40-pc">
                                                    <label class="company-label text-right fs-12">Default VAT Type:&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="inlineBlock width-60-pc">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <vue-single-select
                                                            name="maybe"
                                                            placeholder=""
                                                            you-want-to-select-a-post="ok"
                                                            v-model="form.vat"
                                                            out-of-all-these-posts="makes sense"
                                                            :options="vats"
                                                            a-post-has-an-id="good"
                                                            the-post-has-a-title="make"
                                                            option-label="display_as"
                                                        ></vue-single-select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="width-45-pc float-left mg-top-20">
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-100-pc">
                                                    <label class="fullname fw-600 fs-14">Other</label>
                                                </div>
                                            </div>
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-40-pc">
                                                    <label class="company-label text-right fs-12">Currency:&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="inlineBlock width-60-pc">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <vue-single-select
                                                            name="maybe"
                                                            placeholder=""
                                                            you-want-to-select-a-post="ok"
                                                            v-model="supplier_currency"
                                                            out-of-all-these-posts="makes sense"
                                                            :options="countries"
                                                            a-post-has-an-id="good"
                                                            the-post-has-a-title="make"
                                                            option-label="display_as"
                                                        ></vue-single-select>
                                                        <!-- <input v-model="form.name" required placeholder="e.g Moi Avenue" v-bind:class="{'height-32':true,'custom-attended-field':form.name}" type="text"> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-40-pc">
                                                    <label class="company-label text-right fs-12">Payment Terms:&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="inlineBlock width-60-pc">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <vue-single-select
                                                            name="maybe"
                                                            placeholder=""
                                                            you-want-to-select-a-post="ok"
                                                            v-model="payment_term"
                                                            out-of-all-these-posts="makes sense"
                                                            :options="customer_terms"
                                                            a-post-has-an-id="good"
                                                            the-post-has-a-title="make"
                                                            option-label="name"
                                                        ></vue-single-select>
                                                        <!-- <input v-model="form.name" required placeholder="e.g Moi Avenue" v-bind:class="{'height-32':true,'custom-attended-field':form.name}" type="text"> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                <div class="inlineBlock width-60-pc">
                                                    <label class="company-label text-right fs-12">Auto Allocate Payments to Oldest Invoice:&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="inlineBlock width-40-pc">
                                                    <label class="check-container small width-100-pc">
                                                        <input v-model="form.old_invoice_payment_auto_locate" type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- -------------------Payment & Billings Ends Here------------ -->
                                    </div>
                                </div>
                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===4}" :id="'nav-transactions-'+'4'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'4'" :key="'tab_index_'+'4'">
                                    <div class="width-100-pc padding-left-15 padding-right-15 float-left bg-f4 padding-bottom-20">
                                        <div class="width-100-pc float-left mg-top-20">
                                            <div class="width-100-pc float-left fullName mg-bottom-10">
                                                <div class="width-100-pc float-left">
                                                    <label class="fullname fw-600 fs-14">File Uploads</label>
                                                </div>
                                            </div>
                                            <div class="width-100-pc float-left mg-bottom-10 padding-20 bg-white">
                                                <multiple-files-upload v-on:filesAttached="setFiles" files_data="files_data"></multiple-files-upload>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div v-if="user_mode==='Create'" class="btn-group float-right" role="group">
                        <button :disabled="processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Save
                        </button>
                        <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                            <a @click="add_customer(FORM_ACTIONS.SAVE_NEW)" class="dropdown-item pointer-cursor">{{FORM_ACTIONS.SAVE_NEW}}</a>
                            <a @click="add_customer(FORM_ACTIONS.SAVE_CLOSE)" class="dropdown-item pointer-cursor">{{FORM_ACTIONS.SAVE_CLOSE}}</a>
                        </div>
                    </div>
                    <button v-else :disabled="processing" @click="add_customer(FORM_ACTIONS.SAVE_CLOSE)" type="button" class="btn btn-secondary banking-process-amref">
                        Save
                    </button>
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                    <button v-else :disabled="processing" type="button" data-dismiss="modal" class="btn btn-secondary banking-process">
                        Close
                    </button>
                    
                </div>
            </form>
        </div>
    </div>
    
</template>

<script>
    import {get,post} from '../../../../../../helpers/api';
    import AppInfo from '../../../../../../helpers/config';
    import {createHtmlErrorString,reset_forms, format_lunox_date,formatMoney} from '../../../../../../helpers/functionmixin';
    import {SUPPLIERS_URL} from '../../../../../../router/api_routes';
    import {ADDRESS_TYPES,FORM_ACTIONS} from '../../../../../../helpers/process_status';
    import ImagePreview from "../../../../../../components/images/ImagePreview";
    import MultipleFilesUpload from "../../../../../../components/images/MultipleFilesUpload";
    export default {
        name: "SupplierModal",
        components: {ImagePreview,MultipleFilesUpload},
        props:['form_data','filters','currency','customer_api','user_mode','modal_id','countries','vats','prices','customer_terms','title','banks','bank_branches','bank_account_types'],
        data(){
            return {
                processing: false,
                curr_tab: 0,
                logo: null,
                bank: null,
                bank_branch: null,
                payment_term: null,
                supplier_currency: null,

                files_array:[],
                form: {
                    logo: null,
                    //payment_term: null,
                    vat: null,
                    //price: null,
                    category: 'Local',
                    salutation: null,
                    notes: null,
                    first_name: null,
                    last_name: null,
                    status: true,
                    credit_limit: null,
                    //sales_rep: null,
                    opening_balance: null,
                    default_discount: null,
                    //cash_sale_customer: false,
                    //accept_electronic_invoices: false,
                    old_invoice_payment_auto_locate: false,
                    document_sending_by: null,
                    legal_name: null,
                    //company: null,
                    display_name: null,
                    email: null,
                    mobile: null,
                    phone: null,
                    currency: null,
                    balance: null,
                    as_of: null,
                    tax_reg_number: null,
                    billing: null,
                    shipping: null,
                    // account_number: null,
                    // account_name: null,
                    // bank_id: null,
                    // bank_branch_id: null,
                    // account_type_id: null,
                },
                billing: {
                    address: null,
                    city: null,
                    region: null,
                    postal_code: null,
                    country: null,
                    zip_code: null,
                    phone: null,
                    fax: null,
                    type: ADDRESS_TYPES.BILLING,
                },
                shipping: {
                    address: null,
                    city: null,
                    region: null,
                    postal_code: null,
                    country: null,
                    zip_code: null,
                    phone: null,
                    fax: null,
                    type: ADDRESS_TYPES.SHIPPING,
                },
                FORM_ACTIONS: FORM_ACTIONS,
                selected_bank_branches: [],
            }
        },
        watch: {
            // bank: function(){
            //     if(this.bank){ this.form.bank_id = this.bank.id; }
            //     this.selected_bank_branches = [];
            //     for (let index = 0; index < this.bank_branches.length; index++) {
            //         const element = this.bank_branches[index];
            //         if(element.bank.id === event.target.value){
            //             this.selected_bank_branches.push(element);
            //         }
            //     }
            // }
        },
        methods: {

            copy_address(){
                this.shipping.address = this.billing.address;
                this.shipping.city = this.billing.city;
                this.shipping.region = this.billing.region;
                this.shipping.postal_code = this.billing.postal_code;
                this.shipping.country = this.billing.country;
                this.shipping.zip_code = this.billing.zip_code;
                this.shipping.phone = this.billing.phone;
                this.shipping.fax = this.billing.fax;
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            setBranch(event){
                this.selected_bank_branches = [];
                for (let index = 0; index < this.bank_branches.length; index++) {
                    const element = this.bank_branches[index];
                    if(element.bank.id === event.target.value){
                        this.selected_bank_branches.push(element);
                    }
                }
            },

            setFile(logo_data){
                this.logo = logo_data;
                console.info(this.logo);
            },
            setFiles(file_array){
                this.files_array = file_array;
            },

            reject_negatives(event){
                if(event.target.value < 0){
                    event.target.value = "";
                }
            },

            toggleTab(cur_tab){
                this.curr_tab = cur_tab;
            },

            add_customer: function (action_taken) {
                this.processing = true;
                if(this.supplier_currency){ this.form.currency_id = this.supplier_currency.id; }
                if(this.payment_term){ this.form.payment_term_id = this.payment_term.id }
                // if(this.form.company){ formData.append("company_id",this.form.company.id) }
                // if(this.bank){ this.form.bank_id = this.bank.id; }
                // if(this.bank_branch){ this.form.bank_branch_id = this.bank_branch.id; }
                this.form.billing = this.billing;
                this.form.shipping = this.shipping;
                if(this.form.vat){ this.form.vat_id = this.form.vat.id; }
                this.form.display_as = this.form.salutation+' '+this.form.first_name+' '+this.form.last_name;
                post(this.customer_api,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if ( this.user_mode === 'Create' ) {
                                this.$emit('customer-created-event');
                                this.processing = false;
                                switch(action_taken){
                                    case FORM_ACTIONS.SAVE_NEW:
                                        // this.form = reset_forms(this.form);
                                        // this.billing = reset_forms(this.billing);
                                        // this.shipping = reset_forms(this.shipping);
                                        break;
                                    case FORM_ACTIONS.SAVE_CLOSE:
                                        // this.form = reset_forms(this.form);
                                        // this.billing = reset_forms(this.billing);
                                        // this.shipping = reset_forms(this.shipping);
                                        $('#'+this.modal_id).modal('hide');
                                        break;
                                }
                            }else {
                                //this.$emit('supplierEdited');
                                //$('#'+this.modal_id).modal('hide');
                                this.processing = false;
                            }
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            },
        },
        mounted() {
            if(this.user_mode === "Edit"){
                this.form = this.form_data;
                this.billing = this.form_data.addresses.billing;
                this.shipping = this.form_data.addresses.shipping;
                if(this.form_data.bank_account){
                    this.form.account_number = this.form_data.bank_account.account_number;
                    this.form.account_name = this.form_data.bank_account.account_name;
                    this.form.account_type_id = this.form_data.bank_account.account_type.id;
                    this.bank = this.form_data.bank_account.bank;
                    this.bank_branch = this.form_data.bank_account.bank_branch;
                }
            }else{
                this.form.as_of = format_lunox_date(this.filters.today)
            }
        },
    }
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-content{
        top: 50px!important;
    }
    .modal-lg {
        max-width: 1000px!important;
        min-width: 1000px!important;
    }
    .modal-header{
        border-bottom: 1px solid #00000033!important;
    }
    .pd-l-55{padding-left: 55px!important;}
    .pd-r-55{padding-right: 55px!important;}
    .dijitDialogTitle {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
        /* line-height: 70px; */
        line-height: 50px!important;
        max-width: calc(100% - 40px);
    }
    .fullAdd.employeeForm .row {
        padding-bottom: 4px;
    }
    .inlineBlock {
        display: inline-block;
    }
    .inlineBlock label {
        /* font-weight: 600!important; */
        color: #404040!important;
        display: block!important;
        margin-bottom: 4px!important;
        font-size: 13px;
    }
    .dijitInline {
        display: inline-block;
        border: 0;
        padding: 0;
        vertical-align: middle;
    }
    .dijitTextBox input, .dijitTextBox textarea, .dijitTextBox select, .vdatetime-input{
        outline: none!important;
        height: 27px!important;
        border: 1px solid #BABEC5!important;
        padding: 0 8px!important;
        border-radius: 5px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 12px!important;
        background-color: #FFFFFF;
        box-sizing: border-box!important;
        -webkit-appearance: none!important;
        width: 100%;
        vertical-align: middle!important;
    }

    input::placeholder, textarea::placeholder  {
        color: #babec5!important;
        font-size: 12px!important;
        font-style: italic;
        font-weight: 400!important;
    }
    .checkboxInline {
        margin-left: 5px;
    }
    input[type=checkbox]:not(.dijitCheckBoxInput):not(.idsCheckbox__input) {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        background-color: transparent;
        border: 1px solid #8D9096;
        border-radius: 2px;
        background-repeat: no-repeat;
        background-size: 124px;
        background-position: -28px -3px;
        user-select: none;
        -webkit-appearance: none;
    }
</style>