<template>
    <form @submit.prevent="send_me_link">
        <div class="form-group mg-lg-top-20">
            <label>Send me a link to the app</label>
            <div class="input-group mb-3">
                <input v-model="link_form.mobile" type="number" required class="form-control height-lg-40 no-shadowed border-radius-zero" placeholder="254">
                <button type="submit" class="btn btn-light-blue no-shadowed border-radius-zero height-lg-40">Send</button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        data(){
            return {
                link_form: {
                    mobile: ''
                }
            }
        },
        methods: {
            send_me_link(){
                alert('Coming soon...')
            }
        }
    }
</script>

<style scoped>

</style>
