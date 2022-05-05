export default class Request {
    _request = null;

    constructor(request) {
        this._request = request;
    }

    getRequest() {
        return this._request;
    }
}