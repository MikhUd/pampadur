<template>
<nav>
    <div class="nav-wrapper">
      <a href="#" class="brand-logo center">Logo</a>
      <ul id="nav-mobile" class="left hide-on-med-and-down">
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
        <li v-if="this.$store.getters.isLoggedIn">
            <a @click="logout()" class="waves-effect waves-light" href="#">
                Выйти
            </a>
        </li>
      </ul>
    </div>
</nav>
</template>

<script>
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
