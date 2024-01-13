import { useEffect, FormEventHandler, useState } from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import { FcGoogle } from 'react-icons/fc';
import { useTranslation } from '@/hooks/i18n';

export default function Login({
    status,
    canResetPassword,
}: {
    status?: string;
    canResetPassword: boolean;
}) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const { t } = useTranslation('pages.login');

    const [disabled, setDisabled] = useState<boolean>(true);

    useEffect(() => {
        if (data.email && data.password) {
            setDisabled(false);
        }
    }, [data]);

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('login'));
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            {status && (
                <div className="mb-4 font-medium text-sm text-green-600">
                    {status}
                </div>
            )}

            <form onSubmit={submit}>
                <div className="my-4">
                    <InputLabel
                        htmlFor="email"
                        value={t('.inputLabel.email')}
                    />

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        isFocused={true}
                        onChange={(e) => setData('email', e.target.value)}
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel
                        htmlFor="password"
                        value={t('.inputLabel.password')}
                    />

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="current-password"
                        onChange={(e) => setData('password', e.target.value)}
                    />

                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="block mt-4">
                    <label className="flex items-center">
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            onChange={(e) =>
                                setData('remember', e.target.checked)
                            }
                        />
                        <span className="ms-2 text-sm text-gray-600">
                            {t('.uiText.rememberMe')}
                        </span>
                    </label>
                </div>

                <div className="flex items-center justify-between mt-4">
                    <Link
                        href={route('register')}
                        className="underline text-sm  text-green-600 hover:text-blue-700 rounded-md focus:outline-none  focus:ring-indigo-500"
                    >
                        {t('.uiText.gotoRegister')}
                    </Link>

                    {canResetPassword && (
                        <Link
                            href={route('password.request')}
                            className="underline text-sm  text-green-600 hover:text-blue-700 rounded-md focus:outline-none  focus:ring-indigo-500"
                        >
                            {t('.uiText.forgotPassword')}
                        </Link>
                    )}
                </div>
                <div className="flex items-end justify-end flex-col mt-4">
                    <PrimaryButton
                        className="ms-4 focus:outline-none focus:ring focus:ring-green-300"
                        disabled={processing || disabled}
                    >
                        {t('.loginTitle')}
                    </PrimaryButton>
                </div>

                <div className="flex items-start justify-start my-2 flex-col ">
                    <span className="text-sm">
                        {t('.uiText.loginBySocial')}
                    </span>
                    <Link href={route('social.login', ['google'])}>
                        <FcGoogle className="size-8 mt-4" />
                    </Link>
                </div>
            </form>
        </GuestLayout>
    );
}
