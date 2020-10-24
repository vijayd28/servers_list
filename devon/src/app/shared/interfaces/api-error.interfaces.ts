/**
 * Error Types
 */
export interface Errors  {
    /**
     * Errors that are due to bad data submission
     *
     * @type {(string | any)}
     */
    formError: string | any;

    /**
     * Errors that are due to backend. Mostly all GET methods.
     *
     * @type {(string | any)}
     */
    error: string | any;

    /**
     * Response status code.
     *
     * @type {number}
     */
    status: number;
}
