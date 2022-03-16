<template>
    <div v-if="this.isDatingCardExists">
        Koke jambo;
    </div>
    <div v-else>
        <CreateDatingCard @createDatingCard="onCreateDatingCard"></CreateDatingCard>
        <Session/>
    </div>
</template>
<script>
import CreateDatingCard from './CreateDatingCard';
import Session from '../auth/Session.vue';
export default {
    components: {
        CreateDatingCard,
        Session,
    },
    data() {
        return {
            isDatingCardExists: null
        }
    },
    mounted() {
        this.isDatingCardExists = this.$store.getters.isDatingCardExists;
        
        axios.get('/api/dating-card').then(response => {
            this.isDatingCardExists = response.data.status;
            this.$store.dispatch('onDatingCardExists', response.data.datingCard);
        });
    },
    methods: {
        onCreateDatingCard() {
            this.isDatingCardExists = true;
        }
    }
}
</script>
<style>

</style>
