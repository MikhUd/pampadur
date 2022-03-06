<template>
    <form class="mx-auto mt-5" style="width: 100%; max-width: 500px">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div>
                    <img class="mx-auto registration_logo" src="https://avatanplus.com/files/resources/original/60280bcb1ccd31779c6e116e.png">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input v-model="form.email" v-on:input="checkEmail" class="w-93 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Email">
                    <p class="text-red-500 text-xs italic">{{ errors['email'] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <input v-model="form.name" v-on:input="checkName" class="w-93 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username">
                    <p class="text-red-500 text-xs italic">{{ errors['name'] }}</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input v-model="form.password" v-on:input="checkPassword" class="w-93 shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                    <p class="text-red-500 text-xs italic">{{ errors['password'] }}</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Repeat Password
                    </label>
                    <input v-model="form.password_confirmation" v-on:input="checkRepeatedPassword" class="w-93 shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" type="password" placeholder="******************">
                    <p class="text-red-500 text-xs italic">{{ errors['password_confirmation'] }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <button id="register" v-on:click.prevent="register" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                        Sign In
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                        Forgot Password?
                    </a>
                </div>
            </form>
            <p class="text-center text-gray-500 text-xs">
                &copy;2022 Pampadur. All rights reserved.
            </p>
        </form>
</template>
<style scoped>
    .w-93.px-3 {
        width:93%;
    }

    .registration_logo {
        width: 100px;
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
                    name: null,
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
            checkName() {
                this.errors['name'] = '';
                if (!this.form.name) {
                    this.errors['name'] = 'Имя пользователя не может быть пустым или больше 30 символов';

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
                this.checkName() &
                this.checkPassword() &
                this.checkRepeatedPassword();
            },
            register() {
                //console.log(window.navigator.userAgent);
                this.errors = {};
                if (!this.checkAllFields()) {
                    this.$set(this.$data, 'errors', this.errors);
                    return;
                }
                axios.post('/register', this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$router.push('/home');
                        this.$store.dispatch('login', response.data.user);
                        M.toast({html: 'Успешная регистрация!'});
                    }
                })
                .catch(error => {
                    if (error.response.data.errors.email) {
                        this.$set(this.$data, 'errors', {email: "Почта уже зарегана"});
                    }
                });
            }
        }
    }
</script>
