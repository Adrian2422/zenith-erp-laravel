/**
 * @filename: lint-staged.config.js
 * @type {import('lint-staged').Configuration}
 */
export default {
  // TypeScript / Vue files: ESLint (fix) + Prettier (write)
  '**/*.{ts,vue}': ['eslint --fix'],

  // PHP files: Laravel Pint (fix)
  '**/*.php': ['./vendor/bin/pint --repair --no-interaction'],
}
