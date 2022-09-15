<template>
    <div>
        <div v-if="this.isDatingCardExists">
            <EditDatingCard @updateDatingCard="onUpdateDatingCard"></EditDatingCard>
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
                isDatingCardExists: null,
            }
        },
        mounted() {
            this.isDatingCardExists = this.$store.getters.isDatingCardExists;
            if (!this.isDatingCardExists) {
                this.getDatingCard();
            }
        },
        computed: {
            isDatingCardUpdated() { 
                return this.$store.getters.isDatingCardUpdated;    
            },
        },
        watch: {
            isDatingCardUpdated(newValue, oldValue) {
                this.getDatingCard();
            },
        },
        methods: {
            getDatingCard() {
                axios.get('/api/dating-card')
                .then(response => {
                    if (response.data.status) {
                        this.isDatingCardExists = response.data.status;
                        this.$store.dispatch('onDatingCardExists', response.data.datingCard);
                    }
                })
                .catch((error) => {
                    console.log('error', error);
                });
            },
            onCreateDatingCard() {
                this.isDatingCardExists = true;
            },
            onUpdateDatingCard() {
                console.log('update status');
                this.$store.dispatch('onDatingCardUpdate');
            }
        }
    }
</script>