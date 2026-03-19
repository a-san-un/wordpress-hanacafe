const js = require("@eslint/js");
const globals = require("globals");

module.exports = [
  js.configs.recommended,
  {
    files: ["assets/js/**/*.js"],
    languageOptions: {
      globals: {
        ...globals.browser,
        ...globals.jquery,
      },
      sourceType: "script",
    },
    rules: {
      "no-unused-vars": [
        "warn",
        {
          argsIgnorePattern: "^_",
          varsIgnorePattern: "^_",
        },
      ],
    },
  },
  {
    ignores: ["node_modules/**"],
  },
];
