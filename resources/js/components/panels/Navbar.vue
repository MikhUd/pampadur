<template>
<nav>
    <div class="nav-wrapper">
        <router-link to="/home" class="brand-logo center fixed">
            <img class="logo_image" src="https://vkclub.su/_data/stickers/diggy/sticker_vk_diggy_039.png" alt="logo_image">
            <div class="fixed top-0 left-16">
                Пампадур
            </div>
        </router-link>
        <ul id="nav-mobile" class="hide-on-med-and-down">
            <router-link
                v-for="item in nav"
                :to="item.path"
                :key="item.path"
                tag="li"
                exact
                active-class="active"
                :class="item.class">
                    <a class="waves-effect waves-light" href="#">
                        {{item.title}}
                    </a>
            </router-link>
            <li class="right" v-if="this.$store.getters.isLoggedIn">
                <a @click="logout()" class="waves-effect waves-light" href="#">
                    Выйти
                </a>
            </li>
        </ul>
    </div>
</nav>
</template>

<script>
    import store from "../../store";

    export default {
        computed: {
            nav() {
                return this.$store.getters.nav(this.$store.getters.isLoggedIn)
            },
        },
        methods: {
            logout() {
                return this.$store.dispatch('logout');
            }
        }
    }
</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
    nav {
        padding: 0 2rem;
    }
    a {
        color: rgb(255, 255, 255) !important;
        text-decoration:none !important;

    }
    .brand-logo {
        font-family: 'Pacifico', cursive;
    }
    .logo_image {
        width: 50px;
    }
</style>