export interface JsendResponse {
    /**
     * Palmnote custom code
     */
    code: number;

    /**
     * Response data
     */
    data: any;

    /**
     * Generic message about the response
     */
    message: string;

    /**
     * Status of the response
     */
    status: 'success|fail';
}
