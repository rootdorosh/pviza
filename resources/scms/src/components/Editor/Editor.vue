<template>
  <mavon-editor
    v-model="model"
  />
</template>

<script>
export default {
  name: 'Editor',
  props: ['value'],
  computed:{
    model: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit('input', value);
      }
    }
  },
}
</script>
