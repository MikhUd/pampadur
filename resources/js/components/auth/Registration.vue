<template>
    <div class="mx-auto mt-5" style="width: 100%; max-width: 500px">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input v-model="Email" v-on:input="checkEmail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Email">
                    <p class="text-red-500 text-xs italic">{{ Errors['Email'] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <input v-model="Username" v-on:input="checkUsername" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username">
                    <p class="text-red-500 text-xs italic">{{ Errors['Username'] }}</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input v-model="Password" v-on:input="checkPassword" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                    <p class="text-red-500 text-xs italic">{{ Errors['Password'] }}</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Repeat Password
                    </label>
                    <input v-model="RepeatedPassword" v-on:input="checkRepeatedPassword" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                    <p class="text-red-500 text-xs italic">{{ Errors['RepeatedPassword'] }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <button @click.prevent="register" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
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
        </div>
</template>

<script>
    export default {
        name: 'Registration',

        data() {
            return {
                Email: null,
                Password: null,
                RepeatedPassword: null,
                Username: null,
                Errors: {}
            }
        },
        methods: {
            checkEmail() {
                const checkRegular = (email) => {
                    let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
                    return reg.test(this.Email);
                };

                this.Errors['Email'] = '';
                if (!this.Email || !checkRegular(this.Email)) {
                    this.Errors['Email'] = 'Ошибка';
                    return false;
                }

                return true;
            },
            checkUsername() {
                this.Errors['Username'] = '';
                if (!this.Username) {
                    this.Errors['Username'] = 'Ошибка';
                    return false;
                }
                return true;
            },
            checkPassword() {
                this.Errors['Password'] = '';
                if (!this.Password || this.Password.length < 7) {
                    this.Errors['Password'] = 'Пароль короче 7 символов';
                    return false;
                }
                return true;
            },
            checkRepeatedPassword() {
                this.Errors['RepeatedPassword'] = '';
                if (!this.RepeatedPassword || this.RepeatedPassword != this.Password) {
                    this.Errors['RepeatedPassword'] = 'Пароли не совпадают';
                    return false;
                }
                return true;
            },
            checkAllFields() {
                return this.checkEmail() && this.checkUsername() && this.checkPassword() && this.checkRepeatedPassword();
            },
            register() {
                axios.post('/registration', {email: this.Email, password: this.Password, name: this.Username}).then(response => {
                    console.log(response);
                });
            }
        }
    }
</script>
