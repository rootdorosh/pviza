import config from "@/config";
import { i18n } from '@/lang';

export const FormHelper = {
  data: function () {
    return {
      optionsNoYes: [
        {value: 0, text: i18n.t('no')},
        {value: 1, text: i18n.t('yes')}
      ]
    }
  },
  methods: {

    getLocales: function() {
      return config.locales;
    },

    getErrorLocale: function(field, locale) {
      var error = false;
      var key = `${locale}.${field}`;
      if (typeof this.errors[key] !== 'undefined') {
        error = this.errors[key][0];
      }
      return error;
    },

    hasErrorsInTabLocale: function(locale) {
      let error = false;
      for (let key in this.errors) {
        if (!key.indexOf(locale + '.')) {
          return true;
        }
      }
      return error;
    },

    hasErrorsInTabMain: function() {
      let error = false;
      for (let key in this.errors) {
        if (!this.isLocaleError(key)) {
          return true;
        }
      }
      return error;
    },

    isLocaleError: function (errorKey) {
      let matchLocale = false;

      for (let locale in this.getLocales()) {
        if (!errorKey.indexOf(locale + '.')) {
          matchLocale = true;
        }
      }

      return !matchLocale;
    }
  }
};
