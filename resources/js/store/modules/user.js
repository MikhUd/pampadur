import helper from "../../helpers";
export default {
    state:{
        user: localStorage.getItem('user') || null,
        dating_card: localStorage.getItem('dating_card') || null,
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
            if (datingCard === null) {
                localStorage.removeItem('dating_card');
            } else {
                localStorage.setItem('dating_card', datingCard);
            }
            state.dating_card = datingCard;
        }
    },
    actions: {
        logout(store) {
            helper.logout();
            store.commit("setAuthUser", null);
            store.commit("setDatingCard", null);
        },
        login(store, user) {
            store.commit("setAuthUser", user);
        },
        onDatingCardExists(store, datingCard) {
            store.commit('setDatingCard', datingCard);
        }
    },
    getters:{
        isLoggedIn(state) {
            return !!state.user;
        },
        isDatingCardExists(state) {
            return !!state.dating_card;
        }
    }
}
