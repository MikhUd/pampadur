<template>
    <form class="mx-auto mt-5" style="width: 100%; max-width: 1200px">
        <h2 class="center">Редактор профиля</h2>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="imageArea d-flex">
                <img :src="this.images[0]" class="imageArea__main_photo">
                <div class="imageArea__others_photo">
                    <img v-for="(image, index) in this.images" v-if="index!=0" :src="image">
                </div>
            </div>
        </form>
    </form>
</template>

<style scoped>
h2 {
    font-family: 'Pacifico', cursive;
    font-size: 2rem;
}
.imageArea {
    width: 660px;
    margin: 0 auto;
}
.imageArea__main_photo {
    width: 420px;
    height: 420px;
}

.imageArea__others_photo img {
    height: 140px;
}
</style>


<script>
export default {
    data() {
      return {
          dating_card: this.$store.getters.getDatingCard,
          images: [],
      }
    },
    beforeMount() {
        axios.get('/api/files?dating_card').then(response => {
            response.data.items.map(el => {
                this.images.push('data:image/png;base64,' + el);
            });
        });
    }
}
</script>
