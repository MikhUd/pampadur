import helper from "../../helpers";
export default {
    state:{
        user: null
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
        setDatingCard(state, datingCard) {
            state.user.dating_card = datingCard;
            localStorage.setItem('user', state.user);
        }
    },
    actions: {
        logout(store) {
            helper.logout();
            store.commit("setAuthUser", null);
        },
        login(store, user) {
            store.commit("setAuthUser", user);
        },
        createDatingCard(store, datingCard) {
            store.commit('setDatingCard', datingCard);
        }
    },
    getters:{
        isLoggedIn(state) {
            return !!state.user;
        },
        isDatingCardExists(state) {
            return !!state.user.dating_card;
        }
    }
}
