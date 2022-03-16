<template></template>
<script>
    export default {
        computed: {
            sessionStatus() { 
                return this.$store.getters.getActiveSessionStatus;    
            }
        },
        methods: {
            setActiveSession() {
                this.$store.dispatch('checkSession');
            },
        },
        watch: {
            sessionStatus(newValue, oldValue) {
                this.$store.dispatch('onLogout');
                this.$router.push('/home');
            }
        },
        beforeMount() {
            document.addEventListener('click', this.setActiveSession);
            document.addEventListener('mousemove', this.setActiveSession);
            document.addEventListener('scroll', this.setActiveSession); 
        }
    }
</script>
