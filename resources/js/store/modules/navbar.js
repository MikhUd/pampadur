export default {
    state: {
        nav:[
            {
                path:'/home',
                title:'Главная',
                auth: true,
                class:'left',
            },
            {
                path:'/profile',
                title:'Профиль',
                auth: true,
                class:'left',
            },
            {
                path: "/registration",
                title: "Зарегистрироваться",
                auth: false,
                class:'right',
            },
            {
                path: "/login",
                title: "Войти",
                auth: false,
                class:'right',
            },
        ]
    },
    mutations:{},
    getters:{
        nav: s => auth => s.nav.filter(n => n.auth === auth),
    }
}
