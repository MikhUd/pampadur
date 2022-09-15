<template>
    <div class="container">
        <form class="container mt-5 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="center">Редактор профиля</h2>
            <div class="overlay" id="modalOverlay"></div>
            <div class="modal-popup" id="modal">
                <div class="cropButtonHolder">
                    <button type="button" id="cropp" @click="startCropping()" class="d-block m-auto center rounded-pill btn bg-gradient-to-r from-pink-400 to-rose-400 hover:from-rose-400 hover:to-pink-400 mt-3">
                        <p class="px-2 text-white">Изменить миниатюру</p>
                    </button>
                </div>
                <div class="cropButtonSaveHolder">
                    <button type="button" id="croppSave" class="d-block m-auto center rounded-pill btn bg-gradient-to-r from-orange-400 to-rose-400 hover:from-rose-400 hover:to-orange-400 mt-3">
                        <p class="px-2 text-white">Сохранить</p>
                    </button> 
                </div>   
            </div>
            <div class="mt-5">
                <div>
                    <div class="row position-relative">
                        <label class="block text-gray-700 text-sm font-bold py-4 bg-gray-100 px-3">
                            Ваши фотографии
                        </label>
                        <div v-for="image in this.images" :key="image.url" class="col-6 col-lg-3 col-md-6 mt-3">
                            <div class="relative">
                                <i @click="deleteFile(image.url)" class="material-icons delete-image absolute">cancel</i>
                                <img @click="watchImage(image.url)" draggable="false" :src="image.url" class="mx-auto rounded-lg shadow">
                            </div>
                        </div>
                        <div v-if="this.images.length < 4" @drop.prevent="handleImageUpload($event)" @dragenter.prevent @dragover.prevent class="col-6 col-lg-3 col-md-6">
                            <div class="mt-3 border-2 border-gray-300 border-dashed rounded-md cover_photo">
                                <div class="space-y-1 text-center">
                                    <svg @click="uploadFile" class="mx-auto cover-photo-icon" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="True">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="text-covering-div">
                                        <div class="flex text-sm text-gray-600 d-flex justify-content-center">
                                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-pink-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span class="text-covering">Загрузить файл</span>
                                                <input @change="handleImageUpload" ref="imageInput" id="file-upload" name="file-upload" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1 text-covering">или перетащите</p>
                                        </div>
                                        <p class="text-xs text-gray-500 text-covering">
                                            PNG, JPG до 10 МБ
                                        </p> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-red-500 text-xs italic position-absolute images__error">{{ errors['images'] }}</p>
                </div>
                <div class="row name_div">
                    <label class="block text-gray-700 text-sm font-bold py-4 bg-gray-100 w-full mb-2 px-3">
                        Имя
                    </label>
                    <input v-model="dating_card.name" v-on:input="checkName" class="browser-default appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight" type="text">
                    <p class="text-red-500 text-xs italic position-absolute name__error">{{ errors['name'] }}</p>
                </div>
                <div class="row about_div">
                    <label class="block text-gray-700 text-sm font-bold py-4 bg-gray-100 w-full mb-2 px-3">
                        О себе
                    </label>
                    <textarea v-model="dating_card.about" v-on:input="checkAbout" @keydown.enter.prevent="" class="area_about rounded w-full px-3"></textarea>
                    <p class="text-red-500 text-xs italic position-absolute about__error">{{ errors['about'] }}</p>
                </div>
                <div class="row tag_div">
                    <label class="block text-gray-700 text-sm font-bold py-4 bg-gray-100 w-full mb-2 px-3">
                        Теги
                    </label>
                    <div class="tags">
                        <div class="chips">
                            <input onpaste="return false;" @keydown.space.prevent id="tags">
                        </div>
                    </div>
                    <p class="text-red-500 text-xs italic position-absolute tags__error">{{ errors['tags'] }}</p>
                </div>
                <div class="row">
                    <label class="block text-gray-700 text-sm font-bold py-4 bg-gray-100 w-full mb-2 px-3" for="seeking_for">
                        Ищу
                    </label>
                    <div class="input-field col s12">
                        <select v-model="dating_card.seeking_for" id="seeking_for">
                            <option value="1">Девушку</option>
                            <option value="2">Парня</option>
                        </select>
                    </div>
                    <p class="text-red-500 text-xs italic position-absolute seeking_for__error">{{ errors['seeking_for'] }}</p>
                </div>
            </div>
            <div class="center mt-3">
                <button type="button"
                v-on:click.prevent="update"
                class="d-block m-auto center rounded-pill btn bg-gradient-to-r from-pink-400 to-rose-400 hover:from-rose-400 hover:to-pink-400 mt-5">
                    <p class="px-2 text-white">Сохранить</p>
                </button> 
            </div>
        </form>
        <p class="text-center text-gray-500 text-xs mt-3">
            &copy;2022 Pampadur. All rights reserved.
        </p>
    </div>
</template>

<script>
    import helper from '../../helpers/index';
    import store from '../../store';
    export default {
        data() {
            return {
                dating_card: this.$store.getters.getDatingCard,
                images: [],
                errors: {},
                croppImage: null,
                colorClasses: ['red', 'pink', 'purple', 'blue', 'teal', 'orange'],
            }
        },
        beforeMount() {
            if (!store.getters.getDatingCard) {
                axios.get('/api/dating-card').then(response => {
                    this.$store.dispatch('onDatingCardExists', response.data.datingCard);
                });
            }

            axios.get('/api/files?dating_card').then(response => {
                response.data.items.map(el => {
                    let name = (Math.random() + 1).toString(36).substring(7);
                    this.images.push(helper.dataURLtoFile('data:image/png;base64,' + el, name + ".png"));
                });
            });
        },
        mounted() {
            const self = this;
            $('#modalOverlay').on('click', () => {
                self.closeModal();
            });
            this.chips = M.Chips.init(document.querySelectorAll('.chips'), {
                'limit' : 6,
                onChipDelete: (e, data) => {
                    self.setTags();
                    self.colorClasses.push(data.className.split(' ')[1]);
                },
                onChipAdd: (e, data) => {
                    self.setTags();
                }
            });
            M.FormSelect.init(document.querySelectorAll('select'));
            this.setCurrentUserTags();
            this.setStyles();
        },
        methods: {
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
            checkName() {
                this.errors['name'] = '';
                if (!this.dating_card.name) {
                    this.errors['name'] = 'Имя не может быть пустым';
                    return false;
                }
                if (this.dating_card.name.length > 30) {
                    this.errors['name'] = 'Имя не может быть длиннее 30 символов';
                    return false;
                }
                return true;
            },
            checkAbout() {
                this.errors['about'] = '';
                if (!this.dating_card.about || this.dating_card.about.length < 20) {
                    this.errors['about'] = 'Побольше расскажите о себе';
                    return false;
                }
                if (this.dating_card.about.length > 50) {
                    this.errors['about'] = 'Не так много';
                    return false;
                }
                return true;
            },
            checkTags() {
                this.reactiveErrorsArray();
                this.errors['tags'] = '';
                if (this.dating_card.tags.length < 2) {
                    this.errors['tags'] = 'Пожалуйста, укажите не меньше 2 тегов';
                    return false;
                }
                return true;
            },
            deleteFile(url) {
                let fileToDelete = this.images.find(x => x.url === url);
                let index = this.images.indexOf(fileToDelete);
                this.images.splice(index, 1);
                this.checkImages();
            },
            watchImage(url) {
                $('.cropButtonSaveHolder').css({'display':'none'});
                $('#modal').css({'display':'unset'});
                $('#modalOverlay').css({'display':'unset'});
                $('.cropButtonHolder').css({'display':'unset'});
                let image = this.makeImage(url);
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
                $('#modal').css({'display':'unset'});
                $('.cropButtonHolder').css({'display':'none'});
                $('.cropButtonSaveHolder').css({'display':'unset'});
                let cropper = helper.getCropperInstance(this.croppImage);
                const cropButtonSave = document.getElementById('croppSave');

                cropButtonSave.onclick = () => {
                    this.reactiveImagesArray();
                    let name = (Math.random() + 1).toString(36).substring(7);
                    let indexOfImage = this.images.indexOf(this.images.find(x => x.url === this.croppImage.src));
                    this.images[
                        indexOfImage != -1 ?
                        indexOfImage :
                        this.images.length
                    ] =  helper.dataURLtoFile(cropper.getCroppedCanvas().toDataURL(), name + ".png");
                    this.closeModal();
                    this.checkImages();
                };
            },
            handleImageUpload(event) {
                const url = URL.createObjectURL(event.dataTransfer ? event.dataTransfer.files[0] : this.$refs.imageInput.files[0]);
                this.croppImage = this.makeImage(url);
                this.watchImage(url)
                this.startCropping();
            },
            makeImage(url) {
                let image = new Image();
                image.src = url;
                image.draggable = false;
                return image;
            },
            reactiveImagesArray() {
                let images = this.images;
                this.$set(this.$data, 'images', {});
                this.$set(this.$data, 'images', images);
            },
            uploadFile() {
                $('#file-upload').click();
            },
            setCurrentUserTags() {
                const instance = M.Chips.getInstance($('.chips'));
                this.dating_card.tags.forEach((item, i, arr) => {
                    this.dating_card.tags.push(item);
                    instance.addChip({
                        tag: item,
                    });
                    const index = Math.floor(Math.random() * this.colorClasses.length);
                    $('.chip:last').addClass(this.colorClasses[index]).css({'color':'white'});
                    this.colorClasses.splice(index, 1);
                });
            },
            setTags() {
                const tagsCount = this.dating_card.tags.length;
                const index = Math.floor(Math.random() * this.colorClasses.length);
                this.dating_card.tags = [];
                Object.values(this.chips[0].chipsData).map(el => this.dating_card.tags.push(el.tag));
                //Костыль (потом исправить)
                if (this.dating_card.tags.length > tagsCount) {
                    $('.chip:last').addClass(this.colorClasses[index]).css({'color':'white'});
                    this.colorClasses.splice(index, 1);
                }
                this.checkTags();
            },
            reactiveErrorsArray() {
                let errors = this.errors;
                this.$set(this.$data, 'errors', {});
                this.$set(this.$data, 'errors', errors);
            },
            setStyles() {
                $('ul li span').css({'color':'#ee6e73'});
            },
            checkAllFields() {
                return this.checkAbout() &
                    this.checkName() &
                    this.checkTags() &
                    this.checkImages();
            },
            update() {
                if (!this.checkAllFields()) {
                    return;
                }

                let formData = new FormData();
                Object.entries(this.images).map(el => {
                    formData.append('images[]', el[1]);
                });

                Object.entries(this.dating_card).map(el => {
                    formData.append(el[0], JSON.stringify(el[1]));
                });

                formData.append("_method", "put");

                axios.post('/api/dating-card/' + this.dating_card.id, formData, {
                    headers: {"Content-Type": "multipart/form-data"}
                }).then((response) => {
                    this.$emit('updateDatingCard');
                });
            },
        }
    }
</script>

<style scoped>
    form {
        width: 100%;
        max-width: 1000px;
    }
    input, textarea {
        font-size:150%;
    }
    textarea:focus, input:focus{
        outline: none;
    }
    h2 {
        font-size: 2rem;
    }
    .material-icons:hover {
        cursor: pointer;
        color:rgb(220, 101, 101);
        transition-delay: 50ms;
    }
    .add_img {
        top: 20%;
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
    .material-icons {
        background-color: white;
        border-radius: 50%;
        color:#ff0008;
        font-size: 24px;
        left: 87%;
    }
    .cover_photo {
        height: 88%;
        box-shadow: inset 0px 0px 5px rgba(224, 218, 218, 0.9);
    }
    .cover-photo-icon {
        color: rgb(104, 104, 104);
        transform: scale(0.4);
    }
    .text-covering-div {
        margin-top:-45px !important;
    }
    .text-covering {
        font-size: 95%;
    }
    .cover-photo-icon:hover {
        cursor: pointer;
        color: rgb(56, 56, 56);
    }
    .area_about {
        min-height: 35px;
        max-height: 100px;
    }
    .tag_div,
    .name_div,
    .about_div {
        display: block !important;
    }
    .images__error {
        margin-top: -20px;
    }
    @media (max-width: 1023px) {
        .material-icons {
            left: 82%;
        }
        .cover-photo-icon {
            transform: scale(0.35);
        }
        .text-covering {
            font-size: 80%;
        }
    }
    @media (max-width: 992px) {
        .material-icons {
            left: 92%;
        }
        .cover_photo {
            height: 92.5%;
        }
        .text-covering {
            font-size: 95%;
        }
    }
    @media (max-width: 767px) {
        .material-icons {
            left: 90%;
        }
        .cover_photo {
            height: 90%;
        }
        .cover-photo-icon {
            transform: scale(0.30);
        }
    }
    @media (max-width: 620px) {
        .cover-photo-icon {
            transform: scale(0.28);
        }
        .text-covering {
            font-size: 80%;
        }
    }
    @media (max-width: 580px) {
        .material-icons {
            left: 88%;
        }
        .cover-photo-icon {
            transform: scale(0.4);
        }
        .text-covering {
            font-size: 70%;
        }
    }
    @media (max-width: 530px) {
        .cover_photo {
            height: 89%;
        }
    }
    @media (max-width: 480px) {
        .material-icons {
            left: 84%;
        }
        .cover_photo {
            height: 88%;
        }
        .cover-photo-icon {
            transform: scale(0.3);
        }
    }
    @media (max-width: 402px) {
        .material-icons {
            left: 80%;
        }
        .cover_photo {
            height: 86%;
        }
        .text-covering {
            font-size: 60%;
        }
    }
    @media (max-width: 380px) {
        .cover-photo-icon {
            transform: scale(0.25);
        }
        .text-covering {
            font-size: 55%;
        }
    }
</style>



