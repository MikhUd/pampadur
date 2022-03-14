import helper from "../../helpers";
export default {
    state:{
        token: localStorage.getItem('token') || null,
        dating_card: JSON.parse(localStorage.getItem('dating_card')) || null,
    },
    mutations:{
        setToken(state, token) {
            localStorage.setItem('token', token);
            if (token == null) {
                localStorage.removeItem('token');
            }
            state.token = token;
        },
        setDatingCard(state, datingCard) {
            localStorage.setItem('dating_card', JSON.stringify(datingCard));
            if (datingCard == null) {
                localStorage.removeItem('dating_card');
            }
            state.dating_card = datingCard;
        }
    },
    actions: {
        onLogin(store, token) {
            store.commit("setToken", token);
        },
        onLogout(store) {
            store.commit('setToken', null);
            store.commit('setDatingCard', null);
        },
        onDatingCardExists(store, datingCard) {
            store.commit('setDatingCard', datingCard);
        }
    },
    getters:{
        isLoggedIn(state) {
            return !!state.token;
        },
        isDatingCardExists(state) {
            return !!state.dating_card;
        },
        getToken(state) {
            return state.token;
        }
    }
}
