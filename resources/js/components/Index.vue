<template>
    <div class="container">
        <navbar></navbar>
        <router-view></router-view>
    </div>
</template>

<script>
import Navbar from './panels/Navbar';
    export default {
        components: {
            Navbar
        },
    }
</script>
