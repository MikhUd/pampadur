import axios from "axios"
import router from "../router";

export default{
    onLogout() {
        axios.post('/api/delete-token');
    }
}
