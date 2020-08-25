var traineeRequest = {

    /**
     * Base api endpoint
     */
    baseUrl : window.traineeApiUrl,

    /**
     * Api Endpoint
     */
    endpoint: null,
    /**
     * Request method, default post
     */
     method :'post',

    /**
     * Request
     */
    request : null,

    /**
     * Response
     */
    response : null,
    /**
     * Error messages
     */
     error : {
        title: window.traineeTranslations.errorTitle,
        message: ''
    },

    /**
     * Response type, possible values are:
     * arraybuffer, blob, document, json, text, stream
     */
    responseType : 'json',
    /**
     * Request headers, default is empty object
     */
    headers : { 'Content-Type': 'application/json' },
    /**
     * Post parameters
     */
    postParams : {},
    /**
     * Get parameters
     */
    getParams : {},

    /**
     * Add post parameter
     * @param key
     * @param value
     */
    addPostParam : function(key, value) {
        traineeRequest.postParams[key] = value;
    },

    /**
     * Add get parameter
     * @param key
     * @param value
     */
    addGetParam : function (key, value) {
        traineeRequest.getParams[key] = value;
    },

    /**
     * Execute request
     * @param success
     * @param error
     * @returns {*}
     */
    execute: function (success, error) {

        traineeRequest.request = axios(traineeRequest.getRequestConfig());
        traineeRequest.request
            .then(function (resp){
                jQuery('.loadingScreen').css('display', 'none');
                success(resp);
            })
            .catch(function(err) {
                jQuery('.loadingScreen').css('display', 'none');
                if (typeof error === 'function') {
                    error(err);
                } else {
                    jQuery('.loadingScreen').css('display', 'none');
                    if(err.response){
                        traineeRequest.error.message = err.response.data.message;
                    }
                    Swal.fire(traineeRequest.error.title, traineeRequest.error.message, 'error');
                    return;
                }
            });
        return traineeRequest.request;
    },

    /**
     * Build config for request
     * @returns {{method: string, url: String, baseURL: string, responseType: string, headers: {}}}
     */
    getRequestConfig: function () {
        var CancelToken = axios.CancelToken;
        var config = {
            method: traineeRequest.method,
            url: traineeRequest.endpoint,
            baseURL: traineeRequest.baseUrl,
            responseType: traineeRequest.responseType,
            cancelToken: new CancelToken(function(c) {
                traineeRequest.abort = c;
            }),
            headers: traineeRequest.headers
        };
        if (traineeRequest.method === 'post' || traineeRequest.method === 'put' || traineeRequest.method === 'patch') {
            config.data = traineeRequest.postParams;
        } else if (traineeRequest.method === 'get') {
            config.params = traineeRequest.getParams;
        }

        return config;
    }
}