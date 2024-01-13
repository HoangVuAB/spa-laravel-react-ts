import GuestLayout from '@/Layouts/GuestLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import { useTranslation } from '@/hooks/i18n';
import { Head, Link } from '@inertiajs/react';

export default function TermsOfUse({ status }: { status?: string }) {
    const { t } = useTranslation();

    return (
        <GuestLayout>
            <Head title="Terms of use" />

            <div className="mb-4 text-sm text-gray-600">Term of use page</div>
            <PrimaryButton>
                <Link href={route('register')}>{t('common.registerPage')}</Link>
            </PrimaryButton>
        </GuestLayout>
    );
}
