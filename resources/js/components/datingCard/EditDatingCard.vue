<template>
    <form class="mx-auto mt-5" style="width: 100%; max-width: 1200px">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="center">Создайте анкету</h2>
            <div class="d-flex mt-3 justify-content-between form">
                <div class="column">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Имя
                        </label>
                        <input v-model="form.name" v-on:input="checkName" placeholder="Александр" id="name" type="text" class="validate">
                        <p class="text-red-500 text-xs italic position-absolute name__error">{{ errors['name'] }}</p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold" for="about">
                            О себе
                        </label>
                        <div class="area_about">
                            <form class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea v-model="form.about" v-on:input="checkAbout" id="about" class="materialize-textarea"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="position-absolute">
                            <p class="text-red-500 text-xs italic d-block position-relative about__error">{{ errors['about'] }}</p>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="birth_date">
                            Дата рождения
                        </label>
                        <div class="birth_date">
                            <input @change="setBirthDate" type="text" class="datepicker" id="birth_date">
                        </div>
                        <p class="text-red-500 text-xs italic position-absolute birth_date__error">{{ errors['birth_date'] }}</p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="tags">
                            Теги
                        </label>
                        <div class="tags">
                            <div class="chips">
                                <input onpaste="return false;" @keyup="setTags" @keydown.space.prevent class="custom-class" id="tags">
                            </div>
                        </div>
                        <p class="text-red-500 text-xs italic position-absolute tags__error">{{ errors['tags'] }}</p>
                    </div>
                </div>
                <div class="mb-3 column">
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold" for="gender">
                            Пол
                        </label>
                        <div class="gender">
                            <select @change="checkSectionBlock" v-model="form.gender" id="gender">
                                <option value="1">Мужской</option>
                                <option value="2">Женский</option>
                            </select>
                        </div>
                        <p class="text-red-500 text-xs italic position-absolute gender__error">{{ errors['gender'] }}</p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold" for="seeking_for">
                            Ищу
                        </label>
                        <div class="input-field col s12">
                            <select @change="checkSectionBlock" v-model="form.seeking_for" id="seeking_for">
                                <option value="1">Девушку</option>
                                <option value="2">Парня</option>
                            </select>
                        </div>
                        <p class="text-red-500 text-xs italic position-absolute seeking_for__error">{{ errors['seeking_for'] }}</p>
                    </div>
                    <div class="center cover-photo-wrapper" @drop="onDrop($event, files)">
                        <div class="mx-auto mt-20 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <label class="block text-sm font-medium text-gray-700 position-absolute">
                                <p class="position-relative" style="top:-65px">Припрекить фото</p>
                            </label>
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="True">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Загрузить файл</span>
                                        <input multiple @change="handleImageUpload" ref="imageInput" id="file-upload" name="file-upload" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">или перетащите</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG до 10 МБ
                                </p>
                                <div v-if="images" id="preview">
                                    <div class="border-dashed border-2 border-gray-300 image-preview" v-for="image in images" :key="image.url">
                                        <i @click="deleteFile(image.url)" class="tiny material-icons right absolute delete-image">cancel</i>
                                        <img :src="image.url"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-red-500 text-xs italic position-absolute images__error">{{ errors['images'] }}</p>
                    </div>
                </div>
            </div>
            <div class="center">
                <button v-on:click.prevent="store" id="register"
                        class="rounded-full btn bg-gradient-to-r from-orange-400 to-rose-400 hover:from-rose-400 hover:to-orange-400"
                        type="button">
                    Создать
                </button>
            </div>
        </form>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    name: null,
                    about: null,
                    birth_date: null,
                    tags: [],
                    gender: null,
                    seeking_for: null
                },
                datePicker: null,
                chips: null,
                images: [],
                errors: {},
                location: [],
            }
        },
        name: 'Profile',
        mounted() {
            this.datePicker = M.Datepicker.init(document.querySelectorAll('.datepicker'), {
                'format' : 'yyyy-mm-d'
            });
            this.chips = M.Chips.init(document.querySelectorAll('.chips'), {
                'limit' : 6
            });
            M.FormSelect.init(document.querySelectorAll('select'));
        },
        methods: {
            store() {
                if (!this.checkAllFields()) {
                    return;
                }
                let coords = [];

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        coords.push(position.coords.latitude);
                        coords.push(position.coords.longitude);
                    });
                    this.location.push(coords[0], coords[1]);
                }
                //console.log(coords);
                let formData = new FormData();
                Object.entries(this.images).map(el => {
                    formData.append('images[]', el[1]);
                });

                Object.entries(this.form).map(el => {
                    formData.append(el[0], JSON.stringify(el[1]));
                });

                axios.post('/dating-card', formData, {
                    headers: {"Content-Type": "multipart/form-data"}
                }).then((r) => {
                    this.$store.dispatch('createDatingCard', r.data.datingCard);
                    this.$emit('createDatingCard', {
                        isDatingCardExists: true
                    });
                });
            },
            reactiveErrorsArray() {
                let errors = this.errors;
                this.$set(this.$data, 'errors', {});
                this.$set(this.$data, 'errors', errors);
            },
            setBirthDate() {
                this.form.birth_date = this.datePicker.toString();
                this.checkBirthDate();
            },
            setTags() {
                this.form.tags = [];
                Object.values(this.chips[0].chipsData).map(el => this.form.tags.push(el.tag));
                this.checkTags();
            },
            handleImageUpload(e) {
                for (let file of this.$refs.imageInput.files) {
                    file['url'] = URL.createObjectURL(file);
                    if (!this.images.find(x => x.name === file.name)) {
                        this.images.push(file);
                    }
                }
                this.checkImages();
                e.target.value = null;
            },
            onDrop() {
                //console.log(123);
            },
            deleteFile(url) {
                let fileToDelete = this.images.find(x => x.url === url);
                let index = this.images.indexOf(fileToDelete);
                this.images.splice(index, 1);
                this.checkImages();
            },
            checkImages() {
                this.errors['images'] = '';
                if (this.images.length < 1) {
                    this.errors['images'] = 'Загрузите хотя бы 1 фотографию';
                    return false;
                }
                return true;
            },
            checkName() {
                this.errors['name'] = '';
                if (!this.form.name) {
                    this.errors['name'] = 'Имя не может быть пустым';
                    return false;
                }
                return true;
            },
            checkAbout() {
                this.errors['about'] = '';
                if (!this.form.about || this.form.about.length < 20) {
                    this.errors['about'] = 'Побольше расскажите о себе';
                    return false;
                }
                if (this.form.about.length > 50) {
                    this.errors['about'] = 'Не так много';
                    return false;
                }
                return true;
            },
            checkTags() {
                this.reactiveErrorsArray();
                this.errors['tags'] = '';
                if (this.form.tags.length < 2) {
                    this.errors['tags'] = 'Пожалуйста укажите не меньше 2 тегов';
                    return false;
                }
                return true;
            },
            checkBirthDate() {
                this.reactiveErrorsArray();
                this.errors['birth_date'] = '';
                const birthDate = Date.parse(this.form.birth_date);
                const eighteenYearsOldDateOfBirth = new Date().setFullYear(new Date().getFullYear() - 18);
                if (!birthDate) {
                    this.errors['birth_date'] = 'Укажите возраст';
                    return false;
                }
                if (eighteenYearsOldDateOfBirth < birthDate) {
                    this.errors['birth_date'] = 'Вам нет 18 лет';
                    return false;
                }
                return true;
            },
            checkSectionBlock() {
                this.errors['seeking_for'] = '';
                this.errors['gender'] = '';
                let isBothCompleted = true;
                if (!this.form.gender) {
                    isBothCompleted = false;
                    this.errors['gender'] = 'Укажите пол';
                }
                if (!this.form.seeking_for) {
                    isBothCompleted = false;
                    this.errors['seeking_for'] = 'Укажите тип объекта поисков';
                }
                return isBothCompleted;
            },
            checkAllFields() {
                return this.checkBirthDate() &
                    this.checkAbout() &
                    this.checkName() &
                    this.checkTags() &
                    this.checkSectionBlock() &
                    this.checkImages();
            }

        }
    }
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
    h2 {
        font-family: 'Pacifico', cursive;
        font-size: 2rem;
    }
    .image-preview {
        max-width: 70px;
    }
    .delete-image:hover {
        cursor: pointer;
        color: red;
    }
    textarea {
        height: 44px;
    }
    .cover-photo-wrapper {
        margin-left:auto;
    }
    .column {
        width: 45%;
    }
    .about__error {
        margin-top: -37px;
    }
    .birth_date,
    .chips {
        margin-bottom: 10px;
    }

    .gender {
        margin-bottom: 32px;
        margin-top: 5px;
    }
    .birth_date__error {
        margin-top: -7px;
    }
    .tags__error,
    .gender__error,
    .seeking_for__error{
        margin-top: -5px;
    }
    @media only screen and (max-width: 579px) {
        .cover-photo-wrapper {
            margin: 0 auto;
        }
        .form {
            flex-direction: column;
        }
        .column {
            width: 100%;
        }
    }
</style>
