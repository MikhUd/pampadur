<template>
    <div v-if="this.isDatingCardExists">
            Koke jambo;
    </div>
    <div v-else>
        <CreateDatingCard @createDatingCard="onCreateDatingCard"></CreateDatingCard>
    </div>
</template>
<script>
import CreateDatingCard from './CreateDatingCard';
export default {
    components: {
        CreateDatingCard
    },
    data() {
        return {
            isDatingCardExists: null
        }
    },
    mounted() {
        this.isDatingCardExists = this.$store.getters.isDatingCardExists;
        if (!this.isDatingCardExists) {
            axios.get('/dating-card').then(response => {
                if (response.data.status) {
                    this.isDatingCardExists = response.data.status;
                    this.$store.dispatch('onDatingCardExists', response.data.datingCard);
                }
            });
        }
    },
    methods: {
        onCreateDatingCard(data) {
            this.isDatingCardExists = data.isDatingCardExists;
        }
    }
}
</script>
<style>

</style>
