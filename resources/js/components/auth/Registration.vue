<template>
    <form class="mx-auto mt-5" style="width: 100%; max-width: 500px">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input v-model="form.Email" v-on:input="checkEmail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Email">
                    <p class="text-red-500 text-xs italic">{{ form.Errors['Email'] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <input v-model="form.Username" v-on:input="checkUsername" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username">
                    <p class="text-red-500 text-xs italic">{{ form.Errors['Username'] }}</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input v-model="form.Password" v-on:input="checkPassword" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                    <p class="text-red-500 text-xs italic">{{ form.Errors['Password'] }}</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Repeat Password
                    </label>
                    <input v-model="form.RepeatedPassword" v-on:input="checkRepeatedPassword" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" type="password" placeholder="******************">
                    <p class="text-red-500 text-xs italic">{{ form.Errors['RepeatedPassword'] }}</p>
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
                &copy;2020 Acme Corp. All rights reserved.
            </p>
        </form>
</template>

<script>
    export default {
        name: 'Registration',

        data() {
            return {
                form: {
                    Email: null,
                    Password: null,
                    RepeatedPassword: null,
                    Username: null,
                    Errors: {}
                }
            }
        },
        methods: {
            checkEmail() {
                const checkRegular = (email) => {
                    let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
                    return reg.test(this.form.Email);
                };

                this.form.Errors['Email'] = '';
                if (!this.form.Email || !checkRegular(this.form.Email)) {
                    this.form.Errors['Email'] = 'Введите корректый адрес';
                    return false;
                }

                return true;
            },
            checkUsername() {
                this.form.Errors['Username'] = '';
                if (!this.form.Username) {
                    this.form.Errors['Username'] = 'Имя пользователя не может быть пустым или больше 30 символов';
                    return false;
                }
                return true;
            },
            checkPassword() {
                this.form.Errors['Password'] = '';
                if (!this.form.Password || this.form.Password.length < 7) {
                    this.form.Errors['Password'] = 'Пароль не может быть короче 7 символов';
                    return false;
                }
                return true;
            },
            checkRepeatedPassword() {
                this.form.Errors['RepeatedPassword'] = '';
                if (!this.form.RepeatedPassword || this.form.RepeatedPassword != this.form.Password) {
                    this.form.Errors['RepeatedPassword'] = 'Пароли не совпадают';
                    return false;
                }
                return true;
            },
            checkAllFields() {
                return this.checkEmail() & this.checkUsername() & this.checkPassword() & this.checkRepeatedPassword();
            },
            register() {
                if (!this.checkAllFields()) {
                    this.$set(this.form.Errors, 'allFields', 'Есть ошибки');
                    return;
                }
                axios.post('/registration',
                    {email: this.form.Email,
                            password: this.form.Password,
                            name: this.form.Username
                    }
                ).then(response => {
                    this.$router.push('/');
                });
            }
        }
    }
</script>
