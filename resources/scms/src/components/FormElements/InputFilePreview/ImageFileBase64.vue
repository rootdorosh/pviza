<template>
  <div class="input-file-preview" :class="{ 'active': src }">
    <div class="input-file-preview__field">

      <input
        ref="file"
        type="file"
        accept="image/*"
        class="d-none"
        @change="onChange"
      />

      <b-button
        class="btn btn-default input-file-preview__btn"
        @click.prevent="$refs.file.click()"
      >
        {{ $t('select.image') }}
      </b-button>
      <b-button
        variant="danger"
        class="btn-width-md"
        v-if="src"
        @click.prevent="onDestroy"
      >
        {{ $t('destroy.image') }}
      </b-button>
    </div>
    <div class="input-file-preview__media" v-if="src">{{ src }}
      <img :src="src" class="input-file-preview__image">
    </div>
  </div>
</template>

<script>
import config from '@/config'

export default {
  name: 'ImageFileBase64',
  props: ['value'],
  data() {
    return {
      src: '',
    }
  },
  computed:{
    model: {
      get() {
        return this.value
      },
      set(value) {
        this.$emit('input', value)
      }
    }
  },
  methods: {
    onChange(event) {
      this.reader(event.target.files[0])
    },
    onDestroy() {
      this.$emit('input', '')
    },
    reader(target) {
      if (target) {
        const reader = new FileReader()
        reader.onloadend = () => {
          let value = {
            'content': reader.result,
            'name': target.name,
          }
          this.src = value.content
          this.$emit('input', value)
        }
        reader.readAsDataURL(target)
      }
    },
    updateSrc() {
      let src = false

      if (this.value !== null) {
        if (typeof this.value === 'object') {
          src = this.value.content
        } else if (this.value !== '') {
          src = config.url + this.value
        }
      }
      this.src = src
    }
  },
  created() {
    this.updateSrc()
  },
  watch: {
    value: {
      handler() {
        this.updateSrc()
      },
      deep: true
    }
  }
}
</script>

<style src="./InputFilePreview.scss" lang="scss" scoped />
