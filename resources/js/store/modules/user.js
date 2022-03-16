import helper from "../../helpers";
export default {
    state: {
        token: localStorage.getItem('token') || null,
        dating_card: JSON.parse(localStorage.getItem('dating_card')) || null,
        isActiveSession: {
            status: true,
            timer: null,
        },
    },
    mutations: {
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
        },
        setActiveSessionStatus(state, data) {
            state.isActiveSession.status = data;
        },
        setActiveSessionTimer(state, data) {
            state.isActiveSession.timer = data;
        },
    },
    actions: {
        onLogin(store, token) {
            store.commit("setToken", token);
        },
        async onLogout(store, logout = true) {
            if (logout) {
                await helper.onLogout();
            }
            store.commit('setToken', null);
            store.commit('setDatingCard', null);
        },
        onDatingCardExists(store, datingCard) {
            store.commit('setDatingCard', datingCard);
        },
        async checkSession({state, commit}) {
            if (state.isActiveSession.status) {
                clearTimeout(state.isActiveSession.timer);

                commit('setActiveSessionTimer', setTimeout(function () {
                    commit('setActiveSessionStatus', false);
                }, 5 * 1000));
            } else {
                commit('setActiveSessionStatus', true);
                //this.onLogout
            }
        },
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
        },
        getActiveSessionStatus(state) {
            return state.isActiveSession.status;
        },
        getDatingCard(state) {
            return state.dating_card;
        }
    }
}
