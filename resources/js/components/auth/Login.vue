<template>
    <form class="mx-auto mt-5" style="width: 100%; max-width: 500px">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div>
                <img draggable="false" class="mx-auto login_logo" src="https://avatanplus.com/files/resources/original/598f24e92db0815dd7282ee3.png">
            </div>
            <h2 class="center">Войдите</h2>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Почта
                </label>
                <input v-model="form.email" v-on:input="checkEmail" class="w-93 shadow appearance-none border rounded py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Email">
                <p class="text-red-500 text-xs italic">{{ errors['email'] }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Пароль
                </label>
                <input v-model="form.password" v-on:input="checkPassword" class="w-93 shadow appearance-none border border-red-500 rounded py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                <p class="text-red-500 text-xs italic">{{ errors['password'] }}</p>
            </div>
            <div class="center">
            <button v-on:click.prevent="login" class="rounded-full btn bg-gradient-to-r from-orange-400 to-rose-400 hover:from-rose-400 hover:to-orange-400" type="button">
                Войти
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

    .login_logo {
        width: 100px;
    }

    h2 {
        font-family: 'Pacifico', cursive;
        font-size: 2rem;
    }
</style>
<script>
    export default {
        name: 'Login',
        data() {
            return {
                form: {
                    email: null,
                    password: null
                },
                errors: {}
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
            checkAllFields() {
                return this.checkEmail() & this.checkPassword();
            },
            login() {
                this.$set(this.$data, 'errors', {});
                if (!this.checkAllFields()) {
                    this.$set(this.$data, 'errors', this.errors);
                    return;
                }

                axios.post('/login', this.form).then(response => {
                    if (response.data.success) {
                        this.$router.push('/profile');
                        this.$store.dispatch('login', response.data.user);
                    } else {
                        this.$set(this.$data, 'errors', {'password': 'Неверный пароль'});
                    }
                });
            }
        }
    }
</script>
