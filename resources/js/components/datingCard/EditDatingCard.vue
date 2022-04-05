<template>
    <form class="mx-auto mt-5" style="width: 100%; max-width: 1200px">
        <h2 class="center">Редактор профиля</h2>

        <div class="slider">
            <ul class="slides relative" style="width: 266px; margin: 0 auto">
                    <li v-for="(image, index) in this.images" style="width: 266px">
                        <button
                            class="carousel-control-prev absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline left-0"
                            type="button"
                            @click="sliderPrevPage"
                        >
                            <span class="carousel-control-prev-icon inline-block bg-no-repeat" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <img :src="image" class="slider__image">
                        <button
                            class="carousel-control-next absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline right-0"
                            type="button"
                            @click="sliderNextPage"
                        >
                            <span class="carousel-control-next-icon inline-block bg-no-repeat" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </li>
            </ul>
        </div>
    </form>
</template>

<style scoped>
h2 {
    font-family: 'Pacifico', cursive;
    font-size: 2rem;
}
</style>


<script>
export default {
    data() {
      return {
          dating_card: this.$store.getters.getDatingCard,
          slider: null,
          images: [],
      }
    },
    beforeMount() {
        axios.get('/api/files?dating_card').then(response => {
            response.data.items.map(el => {
                this.images.push('data:image/png;base64,' + el);
            });
        });
    },
    mounted() {
        let isImagesDownloaded = setInterval(() => {
            if (this.images.length == 0 || document.querySelectorAll('.slider__image').length < this.images.length) {
                return;
            }
            this.slider = M.Slider.init(document.querySelectorAll('.slider'), {interval: 10**10, indicators: false})[0];
            clearInterval(isImagesDownloaded);
        },100);
    },
    methods: {
        sliderNextPage() {
            this.slider.next();
        },
        sliderPrevPage() {
            this.slider.prev();
        }
    }
}
</script>
