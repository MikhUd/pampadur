<template>
    <div v-if="this.isDatingCardExists">
            Koke jambo;
    </div>
    <div v-else>
        <EditDatingCard @createDatingCard="onCreateDatingCard"></EditDatingCard>
    </div>
</template>
<script>
import EditDatingCard from './EditDatingCard';
export default {
    components: {
        EditDatingCard
    },
    data() {
        return {
            isDatingCardExists: null
        }
    },
    mounted() {
        this.isDatingCardExists = this.$store.getters.isDatingCardExists;
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
