<template>
  <div>
    <img :src="url" v-if="url" />
  </div>
</template>

<script>
import config from '@/config';

export default {
  name: 'RenderableImage',
  props: ['data', 'index', 'column'],
  data() {
    return {
      domain: config.url,
      url: '',
    }
  },
  methods: {
    getUrl() {
      const column = (typeof this.data[this.column + '_url'] !== 'undefined')
        ? this.column + '_url'
        : this.column

      const src = this.data[column];

      if (src) {
        this.url = this.domain + src;
      }
    }
  },
  created() {
    this.getUrl();
  }
};
</script>
