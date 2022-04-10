<template>
    <form class="container mt-5 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" style="width: 100%; max-width: 1000px">
        <h2 class="center">Редактор профиля</h2>
        <div class="overlay" id="modalOverlay"></div>
        <div class="modal-popup" id="modal">
            <div class="cropButtonHolder">
                <button type="button" @click="startCropping()" class="d-block m-auto center rounded-full btn bg-gradient-to-r from-orange-400 to-rose-400 hover:from-rose-400 hover:to-orange-400 mt-3">
                    <p>Изменить миниатюру</p>
                </button>
            </div>
            <div class="cropButtonSaveHolder">
               <button type="button" class="d-block m-auto center rounded-full btn bg-gradient-to-r from-orange-400 to-rose-400 hover:from-rose-400 hover:to-orange-400 mt-3">
                    <p>Сохранить</p>
                </button> 
            </div>   
        </div>
        <div class="container mt-2">
            <div class="row">
                <div v-for="image in this.images" :key="image" class="col-sm-3 mt-3" style="max-width: 266px;">
                    <div class="relative">
                        <i @click="deleteFile(image)" class="material-icons delete-image absolute">cancel</i>
                        <img @click="watchImage(image)" draggable="false" :src="image" class="mx-auto">
                    </div>
                </div>
                
                <div v-if="this.images.length < 4" class="col-sm-3" style="max-width: 266px;">
                    <div class="mt-3 border-2 border-gray-300 border-dashed rounded-md" style="height:94%;">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="True">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 d-flex justify-content-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Загрузить файл</span>
                                    <input ref="imageInput" id="file-upload" name="file-upload" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">или перетащите</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG до 10 МБ
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-red-500 text-xs italic position-absolute images__error">{{ errors['images'] }}</p>
        </div>
    </form>
</template>

<script>
    import helper from '../../helpers/index';
    export default {
        data() {
            return {
                dating_card: this.$store.getters.getDatingCard,
                images: [],
                errors: {},
                croppImage: null,
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
            self = this;
            $('#modalOverlay').on('click', function() {
                self.closeModal();
            })
        },
        methods: {
            deleteFile(url) {
                let index = this.images.indexOf(url);
                this.images.splice(index, 1);
                this.checkImages();
            },
            checkImages() {
                this.errors['images'] = '';
                if (this.images.length < 2) {
                    this.errors['images'] = 'Загрузите хотя бы 2 фотографии';
                    return false;
                }
                if (this.images.length > 4) {
                    this.errors['images'] = 'Можно загрузить не более 4 фотографий';
                    return false;
                }
                return true;
            },
            watchImage(url) {
                $('.cropButtonSaveHolder').css({'display':'none'});
                $('#modal').css({'display':'unset'});
                $('#modalOverlay').css({'display':'unset'});
                $('.cropButtonHolder').css({'display':'unset'});
                let image = new Image();
                image.src = url;
                image.draggable = false;
                let imageDiv = document.createElement('div');
                imageDiv.className = "imageDiv mx-auto";
                imageDiv.appendChild(image);
                $('#modal').prepend(imageDiv);
                $('.imageDiv').css({'max-width':'80%'});
                $('.imageDiv img').css({'width':'500px'});
                this.croppImage = image;
            },
            closeModal() {
                $('#modal').find('.imageDiv').remove();
                $('.cropButtonSaveHolder button').off();
                $('#modal').css({'display':'none'});
                $("#modalOverlay").css({'display':'none'});
            },
            startCropping() {
                self = this;
                $('.cropButtonHolder').css({'display':'none'});
                $('.cropButtonSaveHolder').css({'display':'unset'});
                let cropper = helper.getCropperInstance(this.croppImage);
                $('.cropButtonSaveHolder button').on('click', function() {
                    self.reactiveImagesArray();
                    let name = (Math.random() + 1).toString(36).substring(7);
                    self.images[self.images.indexOf(self.croppImage.src)] = 
                    URL.createObjectURL(helper.dataURLtoFile(cropper.getCroppedCanvas().toDataURL(), name + ".png"));
                    self.closeModal();
                    console.log(self.images);
                });
            },
            reactiveImagesArray() {
                let images = this.images;
                this.$set(this.$data, 'images', {});
                this.$set(this.$data, 'images', images);
            },
        }
    }
</script>

<style scoped>
    h2 {
        font-size: 2rem;
    }
    .delete-image:hover {
        cursor: pointer;
        color:rgb(220, 101, 101);
        transition-delay: 50ms;
    }
    .delete-image {
        color:#ff0008;

        left: 85%;
    }
    img:hover {
        cursor: pointer;
    }
    .cropButtonHolder,
    .cropButtonSaveHolder {
        display: none;
    }
    image {
        width: 266px;
    }
</style>



