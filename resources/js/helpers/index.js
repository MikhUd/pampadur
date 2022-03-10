import axios from "axios"
import router from "../router";

export default{
    logout() {
        axios.post('/logout')
        .then(reponse => {
            if (reponse.data.success) {
                router.push('/login');
            }
        })
    }
}
