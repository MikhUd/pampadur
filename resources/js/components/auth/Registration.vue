<template>
    <form class="mx-auto mt-5" style="width: 100%; max-width: 500px">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div>
                    <img draggable="false" class="mx-auto registration_logo" src="https://avatanplus.com/files/resources/original/60280bcb1ccd31779c6e116e.png">
                </div>
                <h2 class="center">Зарегистрируйтесь</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Почта
                    </label>
                    <input v-model="form.email" v-on:input="checkEmail" class="w-93 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="alex@gmail.com">
                    <p class="text-red-500 text-xs italic position-absolute">{{ errors['email'] }}</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Пароль
                    </label>
                    <input v-model="form.password" v-on:input="checkPassword" class="w-93 shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                    <p class="text-red-500 text-xs italic position-absolute">{{ errors['password'] }}</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Повторите пароль
                    </label>
                    <input v-model="form.password_confirmation" v-on:input="checkRepeatedPassword" class="w-93 shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" type="password" placeholder="******************">
                    <p class="text-red-500 text-xs italic position-absolute">{{ errors['password_confirmation'] }}</p>
                </div>
                <div class="center">
                    <button id="register" v-on:click.prevent="register" class="rounded-pill btn bg-gradient-to-r from-orange-400 to-rose-400 hover:from-rose-400 hover:to-orange-400" type="button">
                        <p class="px-2 text-white">Зарегистрироваться</p>
                    </button>
                </div>
        </form>
            <p class="text-center text-gray-500 text-xs">
                &copy;2022 Pampadur. All rights reserved.
            </p>
    </form>
</template>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
    .w-93.px-3 {
        width:93%;
    }

    .registration_logo {
        width: 100px;
    }

    h2 {
        font-family: 'Pacifico', cursive;
        font-size: 2rem;
    }
</style>
<script>
    export default {
        name: 'Registration',
        mounted() {
            M.updateTextFields();
        },
        data() {
            return {
                form: {
                    email: null,
                    password: null,
                    password_confirmation: null,
                },
                errors: {
                    type: Array,
                    default: () => [],
                }
            }
        },
        methods: {
            checkEmail() {
                const checkRegular = () => {
                    let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
                    return reg.test(this.form.email);
                };

                this.errors['email'] = '';
                if (!this.form.email || !checkRegular(this.form.email)) {
                    this.errors['email'] = 'Введите корректый адрес';
                    return false;
                }
                return true;
            },
            checkPassword() {
                this.errors['password'] = '';
                if (!this.form.password || this.form.password.length < 7) {
                    this.errors['password'] = 'Пароль не может быть короче 7 символов';
                    return false;
                }
                return true;
            },
            checkRepeatedPassword() {
                this.errors['password_confirmation'] = '';
                if (!this.form.password_confirmation || this.form.password_confirmation != this.form.password) {
                    this.errors['password_confirmation'] = 'Пароли не совпадают';
                    return false;
                }
                return true;
            },
            checkAllFields() {
                return this.checkEmail() &
                this.checkPassword() &
                this.checkRepeatedPassword();
            },
            register() {
                this.errors = {};
                if (!this.checkAllFields()) {
                    this.$set(this.$data, 'errors', this.errors);
                    return;
                }
                axios.post('/api/register', this.form)
                .then((response) => {
                    if (response.data.errors) {
                        if (response.data.errors.email) {
                            this.$set(this.$data, 'errors', {'email': response.response.data.errors.email[0]});
                            return;
                        }
                    }
                    if (response.data.success) {
                        this.$store.dispatch('onLogin', response.data.token);
                        this.$router.push('/profile');
                    }
                }).catch((error) => {
                    console.log(error);
                });
            }
        }
    }
</script>
