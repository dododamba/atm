<template>
    <div>
        <gmap-map
                v-bind:center="{lat:10, lng:10}"
                v-bind:zoom="7"
                style="height: 250px">
            <gmap-marker
                    v-bind:key="index"
                    v-for="(m, index) in markers"
                    v-bind:position="m.position"
                    v-bind:clickable="true"
            />
        </gmap-map>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                center: { lat: 62, lng: 10.0},
                markers: [
                    {
                        position: {lat: 62, lng: 10.0}
                    },
                    {
                        position: {lat: 61.75, lng: 11.0}
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>