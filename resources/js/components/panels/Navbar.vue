<template>
    <div>
        <nav class="nav-extended">
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <div class="nav-wrapper">
                <router-link draggable="false" to="/" class="brand-logo center fixed">
                    <img draggable="false" class="mb-2 logo-image d-inline" src="https://vkclub.su/_data/stickers/diggy/sticker_vk_diggy_039.png" alt="logo_image">
                    <div class="d-inline logo-text">
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
                            <a class="waves-effect waves-light" href="">
                                {{item.title}}
                            </a>
                    </router-link>
                    <li class="right" v-if="this.$store.getters.isLoggedIn">
                        <a @click="logout" class="waves-effect waves-light" href="">
                            Выйти
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <ul class="sidenav" id="mobile-demo">
            <router-link
                v-for="item in nav"
                :to="item.path"
                :key="item.path"
                tag="li"
                exact
                @click.native="sidenavClose"
                active-class="active">
                    <a class="waves-effect waves-light" href="">
                        {{item.title}}
                    </a>
            </router-link>
            <li v-if="this.$store.getters.isLoggedIn">
                <a @click="logout" class="waves-effect waves-light" href="">
                    Выйти
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        mounted() {
            document.addEventListener('DOMContentLoaded', function() {
                var elems = document.querySelectorAll('.sidenav');
                var instances = M.Sidenav.init(elems, []);
            });
        },
        computed: {
            nav() {
                return this.$store.getters.nav(this.$store.getters.isLoggedIn)
            },
        },
        methods: {
            logout() {
                this.$store.dispatch('onLogout');
            },
            sidenavClose() {
                $('.sidenav-overlay').click();
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
        width: 200px;
    }
    .logo-image {
        width: 50px;
    }
    .logo-text {
        font-size: 30px;
        margin-right: 5px;
    }
    .sidenav {
        background-color: #ee6e73;
    }
    @media (max-width: 530px) {
        .sidenav {
            max-width: 200px;
        }
    }
</style>
