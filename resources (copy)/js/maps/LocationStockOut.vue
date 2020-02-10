<template>
    <div class="graph-container bg-white padding-top-20">
        <div class="graph-header"><h3>{{title}}</h3></div>
        <div class="ui fitted divider"></div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="delivery-summary padding-10 width-40-pc float-left">
                    <table class="items-analytic-table1 table-hover">
                        <tr>
                            <th style="width: 60%">Item</th>
                            <th style="width: 20%">Facilities</th>
                            <th style="width: 20%">Alternatives</th>
                        </tr>
                        <tr class="table-hover-tr" v-for="(item,index) in stock_out_items" :key="'item'+index">
                            <td>{{item.name}}</td>
                            <td>{{item.total_facility}}</td>
                            <td>{{item.alternatives}}%</td>
                        </tr>
                    </table>
                </div>
                <div class="delivery-summary width-60-pc float-right">
                    <gmap-map
                        :center="center"
                        :zoom="12"
                        style="width:100%;  height: 400px;">
                        <gmap-marker
                            :key="index"
                            v-for="(m, index) in markers"
                            :position="m.position"
                            @click="center=m.position">
                        </gmap-marker>
                    </gmap-map>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AppInfo from '../helpers/config'
    export default {
        props: ['title','chart_value','stock_out_items'],
        data() {
            return {
                processing: false,
                imageData: AppInfo.app_data.default_avatar,
                user_profile: {
                    salute: 'Dr./Mr./Ms.',
                },
                // default to Montreal to keep it simple
                // change this to whatever makes sense
                center: { lat: 45.508, lng: -73.587 },
                //markers: [],
                places: [],
                currentPlace: null,
                startLocation: {
                    lat: 10.3157,
                    lng: 123.8854
                },
                markers: [
                    {
                        full_name: 'Erich  Kunze',
                        lat: '10.31',
                        lng: '123.89'
                    },
                    {
                        full_name: 'Delmer Olson',
                        lat: '10.32',
                        lng: '123.89'
                    }
                ],
            }
        },
        methods: {
            setPlace(place) {
                console.info(place);
                this.currentPlace = place;
            },
            addMarker() {
                if (this.currentPlace) {
                    const marker = {
                        lat: this.currentPlace.geometry.location.lat(),
                        lng: this.currentPlace.geometry.location.lng()
                    };
                    this.markers.push({ position: marker });
                    this.places.push(this.currentPlace);
                    this.center = marker;
                    this.currentPlace = null;
                }
            },
            geolocate: function() {
                navigator.geolocation.getCurrentPosition(position => {
                    this.center = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                });
            }
        },
        mounted(){
            this.geolocate();
        }
    }
</script>
