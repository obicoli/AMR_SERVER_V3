<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content">

                <div class="modal-header">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{modal_title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">

                    <div class="row">
                        <div class="col-xs-12">
                            <h3>Nav Tab left Side </h3>
                            <div class="tabbable tabs-left">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
                                    <li><a href="#about" data-toggle="tab">About</a></li>
                                    <li><a href="#services" data-toggle="tab">Services</a></li>
                                    <li><a href="#contact" data-toggle="tab">Contact</a></li>
                                </ul>
                                <div class="tab-content">

                                    <div class="tab-pane active" id="home">                
                                        <div class="">
                                            <h1>Home Tab</h1>
                                            <p>These lists are meant to identify articles which deserve editor attention because they are the most important for an encyclopedia to have, as determined by the community of participating editors. They may also be of interest to readers as an alternative to lists of overview articles.</p>                 
                                        </div>
                                    </div> 
                                    <div class="tab-pane" id="about"> 
                                        <div class="">
                                            <h1>About Tab</h1>
                                            <p>because they are the most important for an encyclopedia to have, as determined by the community of participating editors. They may also be of interest to readers as an alternative to lists of overview articles.</p>                 
                                        </div>
                                    </div>
                                
                                    <div class="tab-pane" id="services"> 
                                        <div class="">
                                            <h1>Services Tab</h1>
                                            <p>meant to identify articles which deserve editor attention because they are the most important for an encyclopedia to have, as determined by the community of participating editors. They may also be of interest to readers as an alternative to lists of overview articles.</p>                 
                                        </div>
                                    </div>
                                
                                    <div class="tab-pane" id="contact"> 
                                        <div class="">
                                            <h1>Contact Tab</h1>
                                            <p>deserve editor attention because they are the most important for an encyclopedia to have, as determined by the community of participating editors. They may also be of interest to readers as an alternative to lists of overview articles.</p>                 
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-inventory primary">
                        <span>
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                        </span>
                    </button>
                    <button data-dismiss="modal" class="btn btn-inventory">
                        Close
                    </button>
                </div>

            </form>
        </div>

    </div>
    
</template>

<script>
    import SearchItemField from '../../modals/product/SearchItemField';
    import SupplierModal from '../../modals/vendors/SupplierModal';
    import {createHtmlErrorString,create_item,removeElement,formatMoney} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    export default {
        props: ['modal_id','modal_title','practice_id','form_data','suppliers','practice_list'],
        components: {SearchItemField,SupplierModal},
        data(){
            return {
                processing: false,
            }
        },
        watch: {
        },
        methods: {

        },
        mounted(){
        }
    }
</script>

<style lang="scss" scoped>
    // @import '../../../../../../../sass/fulllengthmodals.scss';
    // @import '../../../../../../../sass/transaction_docs.scss';
    .tabs-left > .nav-tabs {
  border-bottom: 0;
}

.tab-content > .tab-pane,
.pill-content > .pill-pane {
  display: none;
}

.tab-content > .active,
.pill-content > .active {
  display: block;
}

.tabs-left > .nav-tabs > li {
  float: none;
}

.tabs-left > .nav-tabs > li > a {
  min-width: 74px;
  margin-right: 0;
  margin-bottom: 3px;
}

.tabs-left > .nav-tabs {
  float: left;
  margin-right: 19px;
  border-right: 1px solid #ddd;
}

.tabs-left > .nav-tabs > li > a {
  margin-right: -1px;
  -webkit-border-radius: 4px 0 0 4px;
     -moz-border-radius: 4px 0 0 4px;
          border-radius: 4px 0 0 4px;
}

.tabs-left > .nav-tabs > li > a:hover,
.tabs-left > .nav-tabs > li > a:focus {
  border-color: #eeeeee #dddddd #eeeeee #eeeeee;
}

.tabs-left > .nav-tabs .active > a,
.tabs-left > .nav-tabs .active > a:hover,
.tabs-left > .nav-tabs .active > a:focus {
  border-color: #ddd transparent #ddd #ddd;
  *border-right-color: #ffffff;
}
</style>


