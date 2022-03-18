<template>
    <div>
        <div v-if="this.isDatingCardExists">
            <EditDatingCard></EditDatingCard>
        </div>
        <div v-else>
            <CreateDatingCard @createDatingCard="onCreateDatingCard"></CreateDatingCard>
        </div>
        <Session/>
    </div>
</template>
<script>
import CreateDatingCard from './CreateDatingCard';
import EditDatingCard from './EditDatingCard';
import Session from '../auth/Session.vue';
export default {
    components: {
        CreateDatingCard,
        EditDatingCard,
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
