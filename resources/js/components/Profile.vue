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
                        <p class="text-red-500 text-xs italic">{{ errors['name'] }}</p>
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
                        <p class="text-red-500 text-xs italic">{{ errors['about'] }}</p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="birth_date">
                            Дата рождения
                        </label>
                        <div class="birth_date">
                            <input @change="setBirthDate" type="text" class="datepicker" id="birth_date">
                        </div>
                        <p class="text-red-500 text-xs italic">{{ errors['birth_date'] }}</p>
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
                        <p class="text-red-500 text-xs italic">{{ errors['tags'] }}</p>
                    </div>
                </div>
                <div class="mb-3 column">
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold" for="gender">
                            Пол
                        </label>
                        <div class="input-field col s12">
                            <select v-model="form.gender" id="gender">
                                <option value="1">Мужской</option>
                                <option value="2">Женский</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold" for="seeking_for">
                            Ищу
                        </label>
                        <div class="input-field col s12">
                            <select v-model="form.seeking_for" id="seeking_for">
                                <option value="1">Девушку</option>
                                <option value="2">Парня</option>
                            </select>
                        </div>
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
                                        <input @change="handleImageUpload" ref="imageInput" id="file-upload" name="file-upload" type="file" class="sr-only">
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
                        <p class="text-red-500 text-xs italic">{{ errors['images'] }}</p>
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
                    tags: null,
                    gender: null,
                    seeking_for: null
                },
                datePicker: null,
                chips: null,
                images: [],
                errors: {},
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
                let formData = new FormData();
                formData.append('image', this.images);
                Object.entries(this.form).map(el => {
                    formData.append(el[0], el[1]);
                });

                axios.post('/dating-card', formData, {
                    headers: {"Content-Type": "multipart/form-data"}
                }).then(() => {

                });
            },
            setBirthDate() {
                this.form.birth_date = this.datePicker.toString();
                this.checkBirthDate();
            },
            setTags() {
                this.form.tags = [];
                Object.values(this.chips[0].chipsData).map(el => this.form.tags.push(el.tag));
            },
            handleImageUpload() {
                let file = this.$refs.imageInput.files[0];
                file['url'] = URL.createObjectURL(file);
                this.images.push(file);
            },
            onDrop() {
                //console.log(123);
            },
            deleteFile(url) {
                let fileToDelete = this.images.find(x => x.url === url);
                let index = this.images.indexOf(fileToDelete);
                this.images.splice(index, 1);
            },
            checkName() {
                this.errors['name'] = '';
                if (!this.form.name) {
                    this.errors['name'] = 'Имя не может быть пустым';
                    console.log(this.errors);
                    return false;
                }
                return true;
            },
            checkAbout() {
                this.errors['about'] = '';
                if (!this.form.about || this.form.about.length < 10) {
                    this.errors['about'] = 'Побольше расскажите о себе';
                    return false;
                }
                if (this.form.about.length > 20) {
                    this.errors['about'] = 'Не так много';
                    return false;
                }
                return true;
            },
            checkBirthDate() {
                this.errors['birth_date'] = '';
                const birthDate = Date.parse(this.form.birth_date);
                const eighteenYearsOldDateOfBirth = new Date().setFullYear(new Date().getFullYear() - 18);

                if (eighteenYearsOldDateOfBirth < birthDate) {
                    this.errors['birth_date'] = 'Вам нет 18';
                    console.log(this.errors)
                    return false;
                }
                return true;
            },


        }
    }
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');

    .input_name {
        max-width: 85%;
    }
    .cover-photo-wrapper {
        margin-left:auto;
    }
    .column {
        width: 45%;
    }
    @media only screen and (max-width: 579px) {
        .input_name {
            max-width: 93.5%;
        }
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
</style>
