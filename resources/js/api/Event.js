import axios from 'axios'



export default {
    add(formData) {
        return axios.post(route('api.event.add'),formData);  
    },
}