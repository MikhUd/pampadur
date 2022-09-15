export default class Response {
    _error = null;
    _response = null;
    _data = null;
    _errorCode = null;
    _errorMessage = null;

    constructor(error, response, data, errorCode = null, errorMessage = null) {
        this._response = response;
        this._data = data;
    }

    getResponse() {
        return this._response;
    }

    getData() {
        return this._data;
    }

    static response(response, isError) {
        return new Response(
            isError,
            response,
            response.data.data,
        );
    }

    static requestCancelled() {
        return new Response(
            true,
            null,
            null,
            'request_cancelled',
            'Запрос был отменен',
        );
    }

    static badRequest() {
        return new Response(
            true,
            null,
            null,
            'bad_request',
            'Некорректные данные запроса',
        );
    }
}