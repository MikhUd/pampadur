<template>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <h1 class="center">Добро пожаловать в Пампадур!</h1>
            <div class="center mt-5">
                <button type="button" class="rounded-full btn bg-gradient-to-r from-orange-400 to-rose-400 hover:from-rose-400 hover:to-orange-400">
                    <router-link to="/registration">Создать аккаунт</router-link>
                </button>
            </div>
    </div>
</template>

<script>
    export default {}
</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
    h1 {
        font-family: 'Pacifico', cursive;
        font-size: 3rem;
    }
</style>
