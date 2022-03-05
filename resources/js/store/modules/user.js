import helper from "../../helpers";
export default {
    state:{
        user: null,
    },
    mutations:{
        setAuthUser(state, user) {
            state.user = user;
        },
    },
    actions: {
        logout() {
            helper.logout()
            state.user = null;
        }
    },
    getters:{
        isLoggedIn(state) {
            return state.user !== null;
        }
    }
}