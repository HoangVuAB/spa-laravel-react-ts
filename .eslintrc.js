module.exports = {
    env: {
        browser: true,
        es2021: true,
        amd: true,
    },
    extends: [
        'eslint:recommended',
        'plugin:@typescript-eslint/recommended',
        'plugin:react/recommended',
        'plugin:react/jsx-runtime',
        'plugin:prettier/recommended',
    ],
    overrides: [
        {
            env: {
                node: true,
            },
            files: ['.eslintrc.{js,cjs}'],
            parserOptions: {
                sourceType: 'script',
            },
        },
    ],
    parser: '@typescript-eslint/parser',
    parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module',
        ecmaFeatures: {
            jsx: true,
            tsx: true,
        },
    },
    plugins: ['@typescript-eslint', 'react'],
    rules: {
        'react/jsx-no-target-blank': 'off',
        'react/prop-types': 'off',
        'prettier/prettier': [
            'error',
            {},
            {
                usePrettierrc: true,
            },
        ],
    },
    settings: {
        react: {
            version: 'detect',
        },
    },
};
