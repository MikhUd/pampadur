import Request from './request';
import Response from './response';

export default class Client {
    _axios = null;
    _requests = new Map();

    constructor(axios) {
        this._axios = axios;
    }

    getAxios() {
        return this._axios;
    }

    send(...args) {
        return new Promise((resolve, reject) => {
            const request = this.request(...args);

            request.getRequest().then((response) => {
                // запрос прошел успешно
                //this.removeRequest(request);

                // валидируем ответ
                if (this.validateResponse(response)) {
                    resolve(Response.response(response, false));
                }
            })
            .catch((error) => {
                // возникла ошибка
                //this.removeRequest(request);

                if (this.getAxios().isCancel(error)) {
                    console.log('Request has been cancelled:', error.message);
                    reject(Response.requestCancelled());
                } else {
                    //Не на все ошибки нужно бросать badRequest (доделать)
                    reject(Response.badRequest(response));
                }
            })
        });
    }

    request(method, url, data = {}, headers = {}, id = undefined) {
        const promise = this[method](url, data, headers);

        const request = (new Request(promise));

        return request;
    }

    get(url, data, headers) {
        return this.getAxios().get(url, this.merge({params: data, headers}));
    }

    post(url, data, headers) {
        return this.getAxios().post(url, data, this.merge({headers}));
    }

    put(url, data, headers) {
        return this.getAxios().put(url, data, this.merge({headers}));
    }

    patch(url, data, headers) {
        return this.getAxios().patch(url, data, this.merge({headers}));
    }

    delete(url, data, headers) {
        return this.getAxios().delete(url, this.merge({params: data, headers}));
    }

    validateResponse(response) {
        return response.data?.success === true;
    }

    merge(...args) {
        return Object.assign({}, ...args);
    }
}