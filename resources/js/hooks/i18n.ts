import { useCallback } from 'react';
import { useTranslation as useOriginalTranslation } from 'react-i18next';

export function useTranslation(scope?: string) {
    const { t } = useOriginalTranslation();
    const customT = useCallback(
        (key: string) => {
            if (key.startsWith('.')) {
                return t(`${scope}${key}`);
            }

            return t(key);
        },
        [scope, t],
    );

    return { t: customT };
}
