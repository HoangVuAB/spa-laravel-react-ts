import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';

import japanese from './languages/ja.json';

i18n.use(initReactI18next).init({
    resources: {
        ja: {
            translation: japanese,
        },
    },

    fallbackLng: 'en',
    lng: 'ja',

    interpolation: {
        escapeValue: false,
    },
});

export default i18n;
