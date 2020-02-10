<template>

    <div class="width-100-pc float-left">

        <form @submit.prevent="submit_request()" class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600 width-30-pc float-left">Sales Order Settings</h3>
                <div class="float-right">
                    <a data-toggle="collapse" @click="togglePanels('so_panel')" :data-target="'#roles_list_div'" class="cl-white pointer-cursor fs-14">
                        <span v-if="so_panel" class="fs-17">-</span>
                        <span v-else class="fs-17">+</span>
                    </a>
                </div>
            </div>
            <div v-bind:class="{'width-100-pc float-left collapse':true,'in':so_panel,'out':!so_panel}">
                <!-- ------------------------------------------------------------------------ -->
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">SO Prefix: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">SO Title: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.so_title" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_title}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Summary: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.so_summary" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_summary}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Terms: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.so_terms" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_terms}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Notes: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                                <textarea v-model="form.so_notes" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_notes}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-45-pc float-left mg-left-10">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Email Subject: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.so_mail_subject" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_mail_subject}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Text Below Phone: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.so_text_below_phone" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_text_below_phone}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Due Term: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.so_due_term" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_due_term}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Bank Details: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.so_bank_details" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_bank_details}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left padding-left-25">
                    <button :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                        <span v-if="processing && so_panel"><i class="fa fa-spinner fa-spin"></i></span>
                        <span v-else>Save Changes</span>
                    </button>
                </div>
                <!-- ------------------------------------------------------------------------------- -->
            </div>
        </form>

        <!-- Invoice Settings -->
        <form @submit.prevent="submit_request()" class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600 width-30-pc float-left">Invoice Settings</h3>
                <div class="float-right">
                    <a data-toggle="collapse" @click="togglePanels('inv_panel')" :data-target="'#inv_form_div'" class="cl-white pointer-cursor fs-14">
                        <span v-if="inv_panel" class="fs-17">-</span>
                        <span v-else class="fs-17">+</span>
                    </a>
                </div>
            </div>
            <div v-bind:class="{'width-100-pc float-left collapse':true,'in':inv_panel,'out':!inv_panel}">
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Invoice Prefix: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.inv_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.inv_prefix}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Invoice Title: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.inv_title" v-bind:class="{'height-32':true,'ctm-attended-field':form.inv_title}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Summary: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.inv_summary" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.inv_summary}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Terms: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.inv_terms" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.inv_terms}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Notes: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                                <textarea v-model="form.inv_notes" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.inv_notes}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-45-pc float-left mg-left-10">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Email Subject: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.inv_mail_subject" v-bind:class="{'height-32':true,'ctm-attended-field':form.inv_mail_subject}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Text Below Phone: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.inv_text_below_phone" v-bind:class="{'height-32':true,'ctm-attended-field':form.inv_text_below_phone}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Due Term: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.inv_due_term" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.inv_due_term}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Bank Details: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.inv_bank_details" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.inv_bank_details}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left padding-left-25">
                    <button :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                        <span v-if="processing && inv_panel"><i class="fa fa-spinner fa-spin"></i></span>
                        <span v-else>Save Changes</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- PO Settings -->
        <form @submit.prevent="submit_request()" class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600 width-30-pc float-left">Purchase Order Settings</h3>
                <div class="float-right">
                    <a data-toggle="collapse" @click="togglePanels('po_panel')" :data-target="'#inv_form_div'" class="cl-white pointer-cursor fs-14">
                        <span v-if="po_panel" class="fs-17">-</span>
                        <span v-else class="fs-17">+</span>
                    </a>
                </div>
            </div>
            <div v-bind:class="{'width-100-pc float-left collapse':true,'in':po_panel,'out':!po_panel}">
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">PO Prefix: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.po_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.po_prefix}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">PO Title: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.po_title" v-bind:class="{'height-32':true,'ctm-attended-field':form.po_title}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">PO Summary: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.po_summary" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.po_summary}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">PO Terms: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.po_terms" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.po_terms}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">PO Notes: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                                <textarea v-model="form.po_notes" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.po_notes}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-45-pc float-left mg-left-10">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">PO Email Subject: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.po_mail_subject" v-bind:class="{'height-32':true,'ctm-attended-field':form.po_mail_subject}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">PO Text Below Phone: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.po_text_below_phone" v-bind:class="{'height-32':true,'ctm-attended-field':form.po_text_below_phone}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">PO Due Term: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.po_due_term" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.po_due_term}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">PO Bank Details: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.po_bank_details" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.po_bank_details}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left padding-left-25">
                    <button :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                        <span v-if="processing && po_panel"><i class="fa fa-spinner fa-spin"></i></span>
                        <span v-else>Save Changes</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Bill Settings -->
        <form @submit.prevent="submit_request()" class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600 width-30-pc float-left">Bills Settings</h3>
                <div class="float-right">
                    <a data-toggle="collapse" @click="togglePanels('bill_panel')" :data-target="'#inv_form_div'" class="cl-white pointer-cursor fs-14">
                        <span v-if="bill_panel" class="fs-17">-</span>
                        <span v-else class="fs-17">+</span>
                    </a>
                </div>
            </div>
            <div v-bind:class="{'width-100-pc float-left collapse':true,'in':bill_panel,'out':!bill_panel}">
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Bill Prefix: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.bill_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.bill_prefix}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Bill Title: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.bill_title" v-bind:class="{'height-32':true,'ctm-attended-field':form.bill_title}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Bill Summary: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.bill_summary" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.bill_summary}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Bill Terms: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.bill_terms" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.bill_terms}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Bill Notes: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                                <textarea v-model="form.bill_notes" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.bill_notes}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-45-pc float-left mg-left-10">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Bill Email Subject: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.bill_mail_subject" v-bind:class="{'height-32':true,'ctm-attended-field':form.bill_mail_subject}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Bill Text Below Phone: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.bill_text_below_phone" v-bind:class="{'height-32':true,'ctm-attended-field':form.bill_text_below_phone}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Bill Due Term: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.bill_due_term" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.bill_due_term}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Bill Bank Details: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.bill_bank_details" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.bill_bank_details}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left padding-left-25">
                    <button :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                        <span v-if="processing && bill_panel"><i class="fa fa-spinner fa-spin"></i></span>
                        <span v-else>Save Changes</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Estimate Settings -->
        <form @submit.prevent="submit_request()" class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600 width-30-pc float-left">Estimate Settings</h3>
                <div class="float-right">
                    <a data-toggle="collapse" @click="togglePanels('est_panel')" :data-target="'#inv_form_div'" class="cl-white pointer-cursor fs-14">
                        <span v-if="est_panel" class="fs-17">-</span>
                        <span v-else class="fs-17">+</span>
                    </a>
                </div>
            </div>
            <div v-bind:class="{'width-100-pc float-left collapse':true,'in':est_panel,'out':!est_panel}">
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Estimate Prefix: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.est_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.est_prefix}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Estimate Title: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.est_title" v-bind:class="{'height-32':true,'ctm-attended-field':form.est_title}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Estimate Summary: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.est_summary" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.est_summary}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Estimate Terms: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.est_terms" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.est_terms}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Estimate Notes: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                                <textarea v-model="form.est_notes" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.est_notes}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-45-pc float-left mg-left-10">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Estimate Email Subject: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.est_mail_subject" v-bind:class="{'height-32':true,'ctm-attended-field':form.est_mail_subject}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Estimate Text Below Phone: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.est_text_below_phone" v-bind:class="{'height-32':true,'ctm-attended-field':form.est_text_below_phone}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Estimate Due Term: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.est_due_term" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.est_due_term}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Estimate Bank Details: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.est_bank_details" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.est_bank_details}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left padding-left-25">
                    <button :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                        <span v-if="processing && est_panel"><i class="fa fa-spinner fa-spin"></i></span>
                        <span v-else>Save Changes</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Credit Note Settings -->
        <!-- <div class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600">Credit Note Settings</h3>
            </div>
            <div class="width-45-pc float-left">
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Credit Note Prefix: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Credit Note Title: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Credit Note Summary: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" placeholder="Pty Ltd" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Credit Note Terms: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Credit Note Notes: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-45-pc float-left mg-left-10">
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Credit Note Email Subject: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Credit Note Text Below Phone: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Credit Note Due Term: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" placeholder="Pty Ltd" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Credit Note Bank Details: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-100-pc float-left padding-left-25">
                <button class="btn btn-inventory btn-amref cl-white float-right">Save</button>
            </div>
        </div> -->
        <form @submit.prevent="submit_request()" class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600 width-30-pc float-left">Credit Note Settings</h3>
                <div class="float-right">
                    <a data-toggle="collapse" @click="togglePanels('cn_panel')" :data-target="'#inv_form_div'" class="cl-white pointer-cursor fs-14">
                        <span v-if="cn_panel" class="fs-17">-</span>
                        <span v-else class="fs-17">+</span>
                    </a>
                </div>
            </div>
            <div v-bind:class="{'width-100-pc float-left collapse':true,'in':cn_panel,'out':!cn_panel}">
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Credit Note Prefix: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.cn_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.cn_prefix}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Credit Note Title: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.cn_title" v-bind:class="{'height-32':true,'ctm-attended-field':form.cn_title}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Credit Note Summary: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.cn_summary" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.cn_summary}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Credit Note Terms: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.cn_terms" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.cn_terms}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Credit Note Notes: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                                <textarea v-model="form.cn_notes" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.cn_notes}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-45-pc float-left mg-left-10">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Credit Note Email Subject: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.cn_mail_subject" v-bind:class="{'height-32':true,'ctm-attended-field':form.cn_mail_subject}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Credit Note Text Below Phone: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.cn_text_below_phone" v-bind:class="{'height-32':true,'ctm-attended-field':form.cn_text_below_phone}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Credit Note Due Term: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.cn_due_term" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.cn_due_term}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Credit Note Bank Details: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.cn_bank_details" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.cn_bank_details}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left padding-left-25">
                    <button :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                        <span v-if="processing && cn_panel"><i class="fa fa-spinner fa-spin"></i></span>
                        <span v-else>Save Changes</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Debit Note Settings -->
        <form @submit.prevent="submit_request()" class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600 width-30-pc float-left">Debit Note Settings</h3>
                <div class="float-right">
                    <a data-toggle="collapse" @click="togglePanels('dn_panel')" :data-target="'#inv_form_div'" class="cl-white pointer-cursor fs-14">
                        <span v-if="dn_panel" class="fs-17">-</span>
                        <span v-else class="fs-17">+</span>
                    </a>
                </div>
            </div>
            <div v-bind:class="{'width-100-pc float-left collapse':true,'in':dn_panel,'out':!dn_panel}">
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Debit Note Prefix: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.dn_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.dn_prefix}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Debit Note Title: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.dn_title" v-bind:class="{'height-32':true,'ctm-attended-field':form.dn_title}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Debit Note Summary: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.dn_summary" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.dn_summary}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Debit Note Terms: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.dn_terms" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.dn_terms}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Debit Note Notes: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                                <textarea v-model="form.dn_notes" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.dn_notes}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-45-pc float-left mg-left-10">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Debit Note Email Subject: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.dn_mail_subject" v-bind:class="{'height-32':true,'ctm-attended-field':form.dn_mail_subject}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Debit Note Text Below Phone: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.dn_text_below_phone" v-bind:class="{'height-32':true,'ctm-attended-field':form.dn_text_below_phone}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Debit Note Due Term: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.dn_due_term" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.dn_due_term}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Debit Note Bank Details: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.dn_bank_details" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.dn_bank_details}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left padding-left-25">
                    <button :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                        <span v-if="processing && dn_panel"><i class="fa fa-spinner fa-spin"></i></span>
                        <span v-else>Save Changes</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Return Settings/////////////////////////////////////////////////////////////////////// -->
        <form @submit.prevent="submit_request()" class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600 width-30-pc float-left">Return Note Settings</h3>
                <div class="float-right">
                    <a data-toggle="collapse" @click="togglePanels('return_panel')" :data-target="'#inv_form_div'" class="cl-white pointer-cursor fs-14">
                        <span v-if="return_panel" class="fs-17">-</span>
                        <span v-else class="fs-17">+</span>
                    </a>
                </div>
            </div>
            <div v-bind:class="{'width-100-pc float-left collapse':true,'in':return_panel,'out':!return_panel}">
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Return Note Prefix: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.return_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.return_prefix}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Return Note Title: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.return_title" v-bind:class="{'height-32':true,'ctm-attended-field':form.return_title}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Return Note Summary: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.return_summary" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.return_summary}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Return Note Terms: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.return_terms" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.return_terms}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Return Note Notes: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                                <textarea v-model="form.return_notes" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.return_notes}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-45-pc float-left mg-left-10">
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Return Note Email Subject: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.return_mail_subject" v-bind:class="{'height-32':true,'ctm-attended-field':form.return_mail_subject}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Return Note Text Below Phone: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.return_text_below_phone" v-bind:class="{'height-32':true,'ctm-attended-field':form.return_text_below_phone}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Return Note Due Term: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.return_due_term" placeholder="" v-bind:class="{'height-32':true,'ctm-attended-field':form.return_due_term}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-15 mg-left-30">
                        <div class="inlineBlock width-30-pc">
                            <label class="company-label">Return Note Bank Details: </label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.return_bank_details" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.return_bank_details}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left padding-left-25">
                    <button :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                        <span v-if="processing && return_panel"><i class="fa fa-spinner fa-spin"></i></span>
                        <span v-else>Save Changes</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Package Settings -->
        <!-- <div class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600">Debit Note Settings</h3>
            </div>
            <div class="width-45-pc float-left">
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Debit Note Prefix: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Debit Note Title: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Debit Note Summary: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" placeholder="Pty Ltd" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Debit Note Terms: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Debit Note Notes: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-45-pc float-left mg-left-10">
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Debit Note Email Subject: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Debit Note Text Below Phone: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Debit Note Due Term: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" placeholder="Pty Ltd" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Debit Note Bank Details: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-100-pc float-left padding-left-25">
                <button class="btn btn-inventory btn-amref cl-white float-right">Save</button>
            </div>
        </div> -->

        <!-- Delivery Challan Settings -->
        <!-- <div class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600">Delivery Challan Settings</h3>
            </div>
            <div class="width-45-pc float-left">
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Delivery Challan Prefix: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Delivery Challan Title: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Delivery Challan Summary: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" placeholder="Pty Ltd" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Delivery Challan Terms: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Delivery Challan Notes: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-45-pc float-left mg-left-10">
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Delivery Challan Email Subject: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Delivery Challan Text Below Phone: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Delivery Challan Due Term: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" placeholder="Pty Ltd" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-100-pc float-left padding-left-25">
                <button class="btn btn-inventory btn-amref cl-white float-right">Save</button>
            </div>
        </div> -->

        <!-- Recurring Invoice -->
        <!-- <div class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600">Recurring Invoice Settings</h3>
            </div>
            <div class="width-45-pc float-left">
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Recurring Invoice Prefix: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Recurring Invoice Title: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Recurring Invoice Summary: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" placeholder="Pty Ltd" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Recurring Invoice Terms: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Recurring Invoice Notes: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-45-pc float-left mg-left-10">
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Recurring Invoice Email Subject: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Recurring Invoice Text Below Phone: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Recurring Invoice Due Term: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" placeholder="Pty Ltd" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Recurring Invoice Bank Details: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-100-pc float-left padding-left-25">
                <button class="btn btn-inventory btn-amref cl-white float-right">Save</button>
            </div>
        </div> -->

        <!-- Retainer Invoice -->
        <!-- <div class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
                <h3 class="fs-14 fw-600">Retainer Invoice Settings</h3>
            </div>
            <div class="width-45-pc float-left">
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Retainer Invoice Prefix: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Retainer Invoice Title: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Retainer Invoice Summary: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" placeholder="Pty Ltd" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Retainer Invoice Terms: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Retainer Invoice Notes: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc float-right">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-45-pc float-left mg-left-10">
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Retainer Invoice Email Subject: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Retainer Invoice Text Below Phone: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Retainer Invoice Due Term: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <input v-model="form.so_prefix" placeholder="Pty Ltd" v-bind:class="{'height-32':true,'ctm-attended-field':form.so_prefix}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row fullName mg-bottom-15 mg-left-30">
                    <div class="inlineBlock width-30-pc">
                        <label class="company-label">Retainer Invoice Bank Details: </label>
                    </div>
                    <div class="inlineBlock width-70-pc">
                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                            <textarea v-model="form.so_prefix" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32 min-height-90':true,'ctm-attended-field':form.so_prefix}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-100-pc float-left padding-left-25">
                <button class="btn btn-inventory btn-amref cl-white float-right">Save</button>
            </div>
        </div> -->

    </div>

</template>

<script>
    import {post} from "../../../../../../helpers/api";
    import {createHtmlErrorString} from "../../../../../../helpers/functionmixin";
    export default {
        name: "FinanceForm",
        props: ['finances','finance_api'],
        data(){
            return {
                processing: false,
                so_panel: true,
                inv_panel: false,
                po_panel: false,
                bill_panel: false,
                est_panel: false,
                cn_panel: false,
                dn_panel: false,
                return_panel: false,
                form: {
                    so_prefix: null,
                    so_title: null,
                    so_summary: null,
                    so_terms: null,
                    so_notes: null,
                    so_mail_subject: null,
                    so_text_below_phone: null,
                    so_due_term: null,
                    so_bank_details: null,
                    so_show_shipping: null,
                }
            }
        },
        watch: {
            finances: function(new_data,old_data){
                this.form = new_data;
            }
        },
        methods: {
            togglePanels(panel_name){
                switch(panel_name){
                    case "so_panel":
                        if(this.so_panel){this.so_panel = false;}else{this.so_panel=true;}
                        break;
                    case "inv_panel":
                        if(this.inv_panel){this.inv_panel = false;}else{this.inv_panel=true;}
                        break;
                    case "po_panel":
                        if(this.po_panel){this.po_panel = false;}else{this.po_panel=true;}
                        break;
                    case "bill_panel":
                        if(this.bill_panel){this.bill_panel = false;}else{this.bill_panel=true;}
                        break;
                    case "est_panel":
                        if(this.est_panel){this.est_panel = false;}else{this.est_panel=true;}
                        break;
                    case "cn_panel":
                        if(this.cn_panel){this.cn_panel = false;}else{this.cn_panel=true;}
                        break;
                    case "dn_panel":
                        if(this.dn_panel){this.dn_panel = false;}else{this.dn_panel=true;}
                        break;
                    case "return_panel":
                        if(this.return_panel){this.return_panel = false;}else{this.return_panel=true;}
                        break
                }
            },
            submit_request(action_taken){
                this.processing = true;
                post(this.finance_api,this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        this.$emit('financeChanged');
                    }
                    this.processing = false;
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });

            },
        },
        mounted(){
            if(this.finances){
                this.form = this.finances;
            }
        }
    }
</script>