module.exports = {
    extends: [
      'plugin:vue/vue3-recommended',
    ],
    rules: {
      'vue/no-unused-vars': 'error',
      'vue/multi-word-component-names': "off",
      'vue/require-default-prop': "off",
      'eol-last': ['error', 'always'],
      'vue/component-tags-order': ['error', {
        'order': ['script', 'template', 'style'],
      }],
      quotes: ['error', 'single'],
    }
  }
