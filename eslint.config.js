import { defineConfigWithVueTs, vueTsConfigs } from '@vue/eslint-config-typescript'
import prettier from 'eslint-config-prettier'
import vue from 'eslint-plugin-vue'
import globals from 'globals'
import typescript from 'typescript-eslint'

const IGNORED_DIRECTORIES = ['vendor', 'node_modules', 'public', 'bootstrap/ssr', 'tailwind.config.js']

const CUSTOM_RULES = {
  'vue/multi-word-component-names': 'off',
  '@typescript-eslint/no-explicit-any': 'off',
}

const LANGUAGE_OPTIONS = {
  globals: {
    ...globals.browser,
  },
}

export default defineConfigWithVueTs(
  ...typescript.configs.recommended,
  vue.configs['flat/recommended'],
  vueTsConfigs.recommended,
  { rules: CUSTOM_RULES },
  { languageOptions: LANGUAGE_OPTIONS },
  { ignores: IGNORED_DIRECTORIES },
  prettier,
)
