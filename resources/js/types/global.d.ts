import { AxiosInstance } from 'axios';
import ziggyRoute from 'ziggy-js';
import Echo from 'laravel-echo';

declare global {
    interface Window {
        axios: AxiosInstance;
    }

    var route: typeof ziggyRoute;
}

declare global {
    interface Window {
        Echo: Echo;
        laravel_echo_port: any;
    }
}
