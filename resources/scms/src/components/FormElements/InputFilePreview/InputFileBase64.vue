<template>
  <div class="input-file-preview" :class="{ 'active': src }">
    <div class="input-file-preview__field">
      <input
        ref="file"
        :id="name"
        :name="name"
        type="file"
        accept="image/*"
        class="d-none"
        @change="onChange"
      />

      <label
        :for="name"
        class="btn btn-default input-file-preview__btn"
      >
        {{ $t('select.image') }}
      </label>
      <b-button
        variant="danger"
        class="btn-width-md"
        v-if="src"
        @click.prevent="onDestroy"
      >
        {{ $t('destroy.image') }}
      </b-button>
    </div>
    <div class="input-file-preview__media" v-if="src">
      <img :src="src" class="input-file-preview__image">
    </div>
  </div>
</template>

<script>
import config from '@/config';
import { bus } from '@/main';

export default {
  name: 'input-file-base64',
  props: ['name', 'value'],
  data() {
    return {
      src: '',
    }
  },
  methods: {
    onChange(event) {
      this.reader(event.target.files[0]);
    },
    onDestroy() {
      this.src = '';
      bus.$emit('file-change-' + this.name, '', true);
    },
    reader(src) {
      if (src) {
        const files = [];
        const reader = new FileReader();

        files.push(src);

        reader.onloadend = () => {
          files[0].preview = reader.result;
          files[0].toUpload = true;

          this.src = files[0].preview;

          bus.$emit('file-change-' + this.name, {
            content: files[0].preview,
            name: files[0].name
          }, false);
        };

        reader.readAsDataURL(src);
      }
    },
    updateSrc() {
      if (this.value) {
        this.src = this.imgSrc(this.value);
      }
    }
  },
  created() {
    this.updateSrc();
  },
  watch: {
    value: {
      handler() {
        this.updateSrc();
      },
      deep: true
    }
  }
}
</script>

<style src="./InputFilePreview.scss" lang="scss" scoped />
