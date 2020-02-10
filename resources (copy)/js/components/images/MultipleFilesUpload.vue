<template>
    <div class="width-100-pc">
        <p class="fs-12">Individual files may not exceed 2.00 MB in size. A maximum of 5 attachments per note or transaction can be added</p>
        <div v-for="(item,index) in total_files" :key="'total_files'+index" class="width-100-pc float-left mg-bottom-5">
            <input class="height-32 custom-attended-field fs-12 float-left width-400-px" type="file" :id="'file_'+index" :ref="'file_'+index" v-on:change="handleFileUploads($event,index,'file_'+index)"/>
            <a class="btn btn-secondary cl-amref banking-process fs-16 pointer-cursor float-left mg-right-5 mg-left-5" title="Remove" @click="removeFile(index)">x</a>
        </div>
        <a class="btn btn-secondary banking-process pointer-cursor mg-left-10 cl-success-light" title="Add" @click="addFile()">+</a>
    </div>
</template>
<script>
    export default {
        props: ['file_data'],
        data(){
            return {
                files_data: [],
                total_files: 1,
            }
        },
        methods:{
            handleFileUploads(event,index,ref_name){
                //this.file = this.$refs.file.files[0];
                //this.$refs[ref_name].ref_name.files[0];
                // console.info(this.$refs[ref_name])
                // console.info(this.$refs[ref_name][0])
                // console.info(this.$refs[ref_name][0].files)
                //console.info(this.$refs[ref_name][0].files[0])
                this.files_data.push(this.$refs[ref_name][0].files[0]);
                this.$emit("filesAttached",this.files_data)
            },
            removeFile(global_index){

            },
            addFile(){
                if(this.total_files < 5){
                    this.total_files += 1;
                }
            }
        }
    }
</script>