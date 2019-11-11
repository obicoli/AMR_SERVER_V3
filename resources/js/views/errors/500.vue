<template>

    <div id="page">

        <sticky-header :classes="classes"></sticky-header>

        <page-header></page-header>

        <main>
            <div id="error_page">
                <div class="container">
                    <div class="row justify-content-center text-center">
                        <div class="col-xl-7 col-lg-9">
                            <h2>500 <i class="icon_error-triangle_alt"></i></h2>
                            <p>Request failed due to internal server error!.</p>
                            <form>
                                <div class="search_bar_error">
                                    <input type="text" class="form-control" placeholder="What are you looking for?">
                                    <input type="submit" value="Search">
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /container -->
            </div>
            <!-- /error_page -->
        </main>
        <!-- /main -->

        <page-footer></page-footer>
    </div>

</template>

<script type="text/javascript">
    import StickyHeader  from '../front/partials/TopThinHeader'
    import PageHeader from '../front/partials/Header'
    import PageFooter from '../front/partials/TopThinHeader'

    export default {
        components: {
            PageHeader,
            PageFooter,
            StickyHeader
        },
        data() {
            return {
                processing: false,
                classes: {
                    header_sticky: true,
                    sticky: true,
                    top_thin_header: true,
                }
            }
        },
        methods: {
        },
    }
</script>


