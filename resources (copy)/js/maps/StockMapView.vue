<template>
    <div class="row justify-content-center">
        <div class="col-lg-12 padding-right-10">
            <div class="width-100-pc">

                    <gmap-map ref="mymap" :center="startLocation"
                    :zoom="12" style="width:100%;height:300">
                        <gmap-info-window :options="infoOptions" :position="infoPosition" :opened="infoOpened" @closeclick="infoOpened=false">
                            {{infoContent}}
                        </gmap-info-window>
                        <gmap-marker v-for="(item, key) in server_data.coordinates" 
                            :key="key" 
                            :position="getPosition(item)" 
                            :clickable="true" @click="toggleInfo(item, key)"
                            :icon="item.markerOptions"
                            :animation="3"
                            :label="item.label"
                            >
                        </gmap-marker>
                    </gmap-map>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "StockMapView",
        props: ['report_type','server_data','report_description'],
        data() {
            return {
                processing: false,
                startLocation: {
                    lat: -1.31967,
                    lng: 36.809
                },
                coordinates: [
                    {
                        full_name: 'AMREF Wilson Airport',
                        lat: '-1.319256',
                        lng: '36.809858'
                    },
                    {
                        full_name: 'Kibera Community Health Centre-Amref',
                        lat: '-1.287232',
                        lng: '36.6982105'
                    },
                    {
                        full_name: 'Amref Enterprises Limited',
                        lat: '-1.2858812',
                        lng: '36.7973609'
                    }
                ],
                infoPosition: null,
                infoContent: null,
                infoOpened: false,
                infoCurrentKey: null,
                infoOptions: {
                    pixelOffset: {
                        width: 0,
                        height: -35
                    },
                    scaleControl: true,
                },
                markerOptions: {
                    url: '/assets/icons/dashboard/indicator_low_21_days.png',
                    size: {width: 50, height: 60, f: 'px', b: 'px',},
                    scaledSize: {width: 50, height: 60, f: 'px', b: 'px',},
                    labelOrigin: this.google && new google.maps.Point(16,-10),
                },
            }
        },
        methods: {

            getPosition: function(marker) {
                return {
                    lat: parseFloat(marker.lat),
                    lng: parseFloat(marker.lng)
                }
            },

            modify_maker_icon_option(maker){
                return maker.labelOrigin = this.google && new google.maps.Point(16,-10);
            },

            toggleInfo: function(marker, key) {
                this.infoPosition = this.getPosition(marker);
                this.infoContent = marker.full_name;
                if (this.infoCurrentKey == key) {
                    this.infoOpened = !this.infoOpened;
                } else {
                    this.infoOpened = true;
                    this.infoCurrentKey = key;
                }
            }
        },
        mounted(){
        }
    }
</script>


