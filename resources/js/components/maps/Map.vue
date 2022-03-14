<template>
    <div id="map" style="width: 100%; height: 300px"></div>
</template>

<script>
    export default {
        mounted() {
            ymaps.ready(init);
            function init() {
            var geolocation = ymaps.geolocation,
            myMap = new ymaps.Map('map', {
                center: [55, 34],
                zoom: 10
            }, {
                searchControlProvider: 'yandex#search'
            });

            geolocation.get({
                provider: 'browser',
                mapStateAutoApply: true
            }).then(function (result) {
                result.geoObjects.options.set('preset', 'islands#blueCircleIcon');
                myMap.geoObjects.add(result.geoObjects);
                this.$emit('setCoords');
            });
            }
        }
    }
</script>

<style scoped>

</style>
