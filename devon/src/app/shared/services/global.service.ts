
import { Injectable } from '@angular/core';
import { isEmpty as $_isEmpty, get as $_get} from 'lodash-es';
import { environment } from "../../../environments/environment";


@Injectable()

/**
 * Global Service
 *
 * @export
 * @class Global
 */
export class GlobalService {

    /**
     * Get environment value by key
     *
     * @param key
     */
    public static getEnv(key: string = '') {
        if ($_isEmpty(key)) {
            return environment;
        }
        return $_get(environment, key, null);
    }

}
