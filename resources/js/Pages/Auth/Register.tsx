import { useEffect, FormEventHandler, useState } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import { useTranslation } from '@/hooks/i18n';
import JapanPostalCode from 'japan-postal-code';
import Checkbox from '@/Components/Checkbox';

export default function Register() {
    const { t } = useTranslation('pages.register');
    const { data, setData, post, processing, errors, reset } = useForm({
        user_name: '',
        user_name_kana: '',
        phone_number: '',
        postcode: '',
        address: '',
        email: '',
        password: '',
        password_confirmation: '',
    });
    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('register'));
    };

    const [disabled, setDisabled] = useState<boolean>(true);
    const [checked, setChecked] = useState<boolean>(false);
    const [address, setAddress] = useState('');

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    useEffect(() => {
        if (address && address !== t('validate.invalidAddress')) {
            setData('address', address);
        }
    }, [address]);

    useEffect(() => {
        if (
            data.user_name &&
            data.email &&
            data.password &&
            data.password_confirmation &&
            checked
        ) {
            setDisabled(false);
        } else {
            setDisabled(true);
        }
    }, [data, checked]);

    const handlePostCodeChange = (e: any) => {
        const postCode = e.target.value;

        if (postCode.length === 7 && /^\d+$/.test(postCode)) {
            JapanPostalCode.get(postCode, (item) => {
                setAddress(`${item.prefecture} ${item.city} ${item.area}`);
            });
        } else {
            setAddress('');
        }

        setData('postcode', e.target.value);
    };

    return (
        <GuestLayout>
            <Head title="Register" />
            <form onSubmit={submit}>
                <div className="flex justify-between mt-4">
                    <div className="pr-2">
                        <InputLabel
                            htmlFor="user_name"
                            value={t('.inputLabel.userName')}
                        >
                            <span className="text-xs text-rose-500 ml-2">
                                {t('common.required')}
                            </span>
                        </InputLabel>

                        <TextInput
                            id="user_name"
                            name="user_name"
                            value={data.user_name}
                            className="mt-1 block w-full"
                            autoComplete="first_name"
                            isFocused={true}
                            onChange={(e) =>
                                setData('user_name', e.target.value)
                            }
                            placeholder={t('.placeholder.userName')}
                            required
                        />

                        <InputError
                            message={errors.user_name}
                            className="mt-2"
                        />
                    </div>
                    <div className="pl-2">
                        <InputLabel
                            htmlFor="first_name_kana"
                            value={t('.inputLabel.furigana')}
                        />

                        <TextInput
                            id="user_name_kana"
                            name="user_name_kana"
                            value={data.user_name_kana}
                            className="mt-1 block w-full"
                            autoComplete="user_name_kana"
                            isFocused={true}
                            onChange={(e) =>
                                setData('user_name_kana', e.target.value)
                            }
                            placeholder={t('.placeholder.userNameKana')}
                        />

                        <InputError
                            message={errors.user_name_kana}
                            className="mt-2"
                        />
                    </div>
                </div>

                <div className="mt-4">
                    <InputLabel
                        htmlFor="phone_number"
                        value={t('.inputLabel.phoneNumber')}
                    />

                    <TextInput
                        id="phone_number"
                        name="phone_number"
                        value={data.phone_number}
                        className="mt-1 block w-full"
                        autoComplete="phone_number"
                        isFocused={true}
                        onChange={(e) =>
                            setData('phone_number', e.target.value)
                        }
                        placeholder={t('.placeholder.phoneNumber')}
                    />

                    <InputError
                        message={errors.phone_number}
                        className="mt-2"
                    />
                </div>

                <div className="flex flex-col">
                    <div className="mt-4 flex flex-row items-center justify-between">
                        <InputLabel
                            htmlFor="postcode"
                            value={t('.inputLabel.postCode')}
                        />

                        <p className="text-xs pl-2 ">
                            {t('.uiText.notUseHyphen')}
                        </p>
                    </div>
                    <div className="flex flex-row items-center">
                        <span className="px-2">〒</span>

                        <TextInput
                            id="postcode"
                            name="postcode"
                            value={data.postcode}
                            className="mt-1 block w-28 size-7"
                            autoComplete="postcode"
                            isFocused={true}
                            onChange={(e) => handlePostCodeChange(e)}
                            placeholder={t('.placeholder.postCode')}
                        />
                    </div>
                    <InputError message={errors.postcode} className="mt-2" />
                </div>

                <div className="mt-4 ">
                    <InputLabel
                        htmlFor="address"
                        value={t('.inputLabel.address')}
                    />

                    <TextInput
                        id="address"
                        name="address"
                        value={address ? address : data.address}
                        className="mt-1 block w-full"
                        autoComplete="address"
                        isFocused={true}
                        onChange={(e) => setData('address', e.target.value)}
                        placeholder={t('.placeholder.address')}
                    />

                    <InputError message={errors.address} className="mt-2" />
                </div>

                <div className="mt-4 ">
                    <InputLabel htmlFor="email" value={t('.inputLabel.email')}>
                        <span className="text-xs text-rose-500 ml-2">
                            {t('common.required')}
                        </span>
                    </InputLabel>

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        onChange={(e) => setData('email', e.target.value)}
                        placeholder={t('.placeholder.email')}
                        required
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4 ">
                    <InputLabel
                        htmlFor="password"
                        value={t('.inputLabel.password')}
                    >
                        <span className="text-xs text-rose-500 ml-2">
                            {t('common.required')}
                        </span>
                    </InputLabel>

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData('password', e.target.value)}
                        required
                    />

                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="mt-4 ">
                    <InputLabel
                        htmlFor="password_confirmation"
                        value={t('.inputLabel.confirmPassword')}
                    >
                        <span className="text-xs text-rose-500 ml-2">
                            {t('common.required')}
                        </span>
                    </InputLabel>

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) =>
                            setData('password_confirmation', e.target.value)
                        }
                        required
                    />

                    <InputError
                        message={errors.password_confirmation}
                        className="mt-2"
                    />
                </div>

                <div className="block mt-4">
                    <label className="flex items-center">
                        <Checkbox
                            name="remember"
                            checked={checked}
                            onChange={(e) => setChecked(e.target.checked)}
                        />

                        <div className="ms-2">
                            <Link
                                href={route('terms')}
                                className="underline text-sm  text-green-600 hover:text-blue-700 rounded-md focus:outline-none  focus:ring-indigo-500"
                            >
                                {t('.uiText.termsOfUse')}
                            </Link>
                            と
                            <Link
                                href={route('policy')}
                                className="underline text-sm  text-green-600 hover:text-blue-700 rounded-md focus:outline-none  focus:ring-indigo-500"
                            >
                                {t('.uiText.privacyPolicy')}
                            </Link>
                            に同意する。
                        </div>
                    </label>
                </div>

                <div className="flex items-between flex-col justify-between mt-4 ">
                    <div className="flex justify-between mt-4 ">
                        <Link
                            href={route('login')}
                            className="underline text-sm  text-green-600 hover:text-blue-700 rounded-md focus:outline-none  focus:ring-indigo-500"
                        >
                            {t('.uiText.alreadyRegistered')}
                        </Link>

                        <PrimaryButton
                            className="ms-4 focus:outline-none focus:ring focus:ring-green-300"
                            disabled={processing || disabled}
                        >
                            {t('.registerTitle')}
                        </PrimaryButton>
                    </div>
                </div>
            </form>
        </GuestLayout>
    );
}
