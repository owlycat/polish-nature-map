module.exports = {
    extends: [
        'eslint:recommended',
        'plugin:vue/vue3-recommended',
    ],
    globals: {
        'route': 'readonly',
        'axios': 'readonly',
    },
    rules: {
        'vue/no-unused-vars': 'error',
        'vue/multi-word-component-names': "off",
        'vue/require-default-prop': "off",
        'eol-last': ['error', 'always'],
        'vue/no-v-html': 'off',
        'vue/component-tags-order': ['error', {
            'order': ['script', 'template', 'style'],
        }],
        quotes: ['error', 'single'],
    }
}
