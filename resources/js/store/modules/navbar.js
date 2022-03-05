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
                path: "/registration",
                title: "Регистрация",
                auth: false,
                class:'',
            },
            {
                path: "/login",
                title: "Логин",
                auth: false,
                class:'',
            },
        ]
    },
    mutations:{},
    getters:{
        nav: s => auth => s.nav.filter(n => n.auth === auth),
    }
}