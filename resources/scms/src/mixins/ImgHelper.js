import config from '@/config';

export const ImgHelper = {
  methods: {
    imgSrc: function (src) {
      if (src && typeof src === 'string') {
        if (src.split('base64').length - 1) {
          return src
        } else {
          return config.url + src;
        }
      }
    }
  }
}
