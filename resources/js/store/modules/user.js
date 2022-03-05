import helper from "../../helpers";
export default {
    state:{
        user: null,
    },
    mutations:{
        setAuthUser(state, user) {
            if (user === null) {
                localStorage.removeItem('user');
            } else {
                localStorage.setItem('user', user);
            }
            state.user = user;
        },
    },
    actions: {
        logout(store) {
            helper.logout();
            store.commit("setAuthUser", null);
        },
        login(store, user) {
            store.commit("setAuthUser", user)
        }
    },
    getters:{
        isLoggedIn(state) {
            return state.user !== null;
        }
    }
}
