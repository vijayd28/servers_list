import { startsWith as $_startsWith, get as $_get, defaultTo as $_defaultTo} from 'lodash-es';

import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpEvent, HttpResponse} from '@angular/common/http';


import { Observable, throwError} from 'rxjs';
import { GlobalService } from './global.service';
import { catchError } from 'rxjs/operators';
import { JsendResponse, Errors } from '../interfaces';

/**
 * Api Service
 *
 * @export
 * @class ApiService
 */
@Injectable()

export class ApiService {

    /**
     * Api Service Constructor
     *
     * @param http {HttpClient}
     */
    public constructor(
        private http: HttpClient
    ) {}

    /**
     * Format errors and rethrow
     *
     * @param error
     * @return {any}
     */
    private static formatErrors(error: HttpErrorResponse) {
        const errorData: JsendResponse = $_get(error, 'error', {});
        const errors: Errors = {
            error: $_defaultTo(
                $_get(errorData, 'message'),
                'Something went wrong. Please check your internet connection and reload the app.'
            ),
            formError: $_get(errorData, ['data', 'validation'], null),
            status: error.status,
            code: $_get(errorData, 'code', null),
        };

        return throwError(errors);
    }

    /**
     * If API Url not is prefixed, add it
     *
     * @private
     * @param {string} url
     * @returns {string}
     *
     * @memberOf ApiService
     */
    private static prepareUrl(url: string): string {
        const apiUrl: string = GlobalService.getEnv('api.base_url');

        return ($_startsWith(url, 'http')) ? url : apiUrl + url;
    }


    /**
     * Interface for HTTP Get
     *
     * @param {string} url
     * @param {URLSearchParams} params
     * @returns {Observable<JsendResponse>}
     *
     * @memberOf ApiService
     */
    public get(url: string, params: Object = {}): Observable<HttpEvent<JsendResponse>> {
        return this.request('GET', url, { params });
    }

    /**
     * Interface for HTTP Post
     *
     * @param {string} url
     * @param {Object} [body]
     * @returns {Observable<JsendResponse>}
     *
     * @memberOf ApiService
     */
    public post(url: string, body?: Object): Observable<HttpEvent<JsendResponse>> {

        return this.request('POST', url, { body });
    }

    /**
     * Interface for HTTP Put
     *
     * @param {string} url
     * @param {Object} [body]
     * @returns {Observable<JsendResponse>}
     *
     * @memberOf ApiService
     */
    public put(url: string, body?: Object): Observable<HttpEvent<JsendResponse>> {

        return this.request('PUT', url, { body });
    }

    /**
     * Interface for HTTP Patch
     *
     * @param {string} url
     * @param {Object} [body]
     * @returns {Observable<JsendResponse>}
     *
     * @memberOf ApiService
     */
    public patch(url: string, body?: Object): Observable<HttpEvent<JsendResponse>> {

        return this.request('PATCH', url, { body });
    }

    /**
     * Interface for HTTP Delete
     *
     * @param {string} url
     * @param {Object} params
     * @returns {Observable<JsendResponse>}
     *
     * @memberOf ApiService
     */
    public delete(url: string, params?: Object): Observable<HttpEvent<JsendResponse>> {

        return this.request('DELETE', url, { params });
    }

    /**
     * @private
     * @param {string} method
     * @param {string} url
     * @param options
     * @returns {Observable<JsendResponse>}
     *
     * @memberOf ApiService
     */
    private request(method: string, url: string, options): Observable<HttpEvent<JsendResponse>> {
        if (options.body) {
            options.body = JSON.stringify(options.body);
        }

        return this
            .http
            .request<JsendResponse>(
                method,
                ApiService.prepareUrl(url),
                options
            )
            .pipe(
                catchError(error => ApiService.formatErrors(error))
            );
    }
}
