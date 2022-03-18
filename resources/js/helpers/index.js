import axios from "axios"
import router from "../router";
import Cropper from 'cropperjs';

export default{
    onLogout() {
        axios.post('/api/delete-token');
    },
    dataURLtoFile(dataurl, filename) {
        var arr = dataurl.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]),
            n = bstr.length,
            u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        let file = new File([u8arr], filename, {type:mime});
        file['url'] = URL.createObjectURL(file);

        return file;
    },
    getCropperInstance(image) {
        return new Cropper(image, {
            aspectRatio: 2/3,
            autoCropArea: true,
            minContainerWidth: 150,
            //minCanvasWidth: 200,
            //minCanvasHeight: 300,
            minCropBoxHeight: 200,
            zoomable: false,
        });
    }
}
