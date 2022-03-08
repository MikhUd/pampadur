<template>
    <form class="mx-auto mt-5" style="width: 100%; max-width: 1200px">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h2 class="center">Создайте анкету</h2>
<div class="d-flex mt-3 flex-wrap">

    <div class="flex-grow-1">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Имя
                    </label>
                    <input class="input_name shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Александр">
                    <p class="text-red-500 text-xs italic"></p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="about_me">
                        О себе
                    </label>
                    <div class="area_about">
                        <form class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                <textarea id="about_me" class="materialize-textarea"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <p class="text-red-500 text-xs italic"></p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="about_me">
                        Дата рождения
                    </label>
                    <div class="birth_date">
                        <input type="text" class="datepicker">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tags">
                        Теги
                    </label>
                    <div class="tags">
                        <div class="chips">
                            <input class="custom-class" id="tags">
                        </div>
                    </div>
                </div>

    </div>
    <div class="flex-grow-1 mb-3">
            <div class="center">
              <label class="block text-sm font-medium text-gray-700">
                Cover photo
              </label>
              <div class="photo_upload mx-auto mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="True">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                      <span>Upload a file</span>
                      <input id="file-upload" name="file-upload" type="file" class="sr-only">
                    </label>
                    <p class="pl-1">or drag and drop</p>
                  </div>
                  <p class="text-xs text-gray-500">
                    PNG, JPG, GIF up to 10MB
                  </p>
                </div>
              </div>
            </div>
    </div>
</div>

                <div class="center">
                    <button id="register" class="rounded-full btn bg-gradient-to-r from-orange-400 to-rose-400 hover:from-rose-400 hover:to-orange-400" type="button">
                        Создать
                    </button>
                </div>
            </form>
            <p class="text-center text-gray-500 text-xs">
                &copy;2022 Pampadur. All rights reserved.
            </p>
    </form>
</template>

<script>
    export default {
        name: 'Profile',
        mounted() {
            M.Datepicker.init(document.querySelectorAll('.datepicker'));
            M.Chips.init(document.querySelectorAll('.chips'));
            M.FormSelect.init(document.querySelectorAll('select'));
        },
        methods: {

        }
    }
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');

    .input_name {
        max-width: 85%;
    }

    .area_about,
    .tags,
    .photo_upload,
    .birth_date {
        max-width: 90%;
    }

    h2 {
        font-family: 'Pacifico', cursive;
        font-size: 2rem;
    }
</style>
