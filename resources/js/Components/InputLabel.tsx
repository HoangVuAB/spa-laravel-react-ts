import { LabelHTMLAttributes } from 'react';

export default function InputLabel({
    value,
    className = '',
    children,
    ...props
}: LabelHTMLAttributes<HTMLLabelElement> & { value?: string }) {
    return (
        <label
            {...props}
            className={`block font-medium text-md text-gray-700 ` + className}
        >
            {value ? value : ''}
            {children ? children : ''}
        </label>
    );
}
