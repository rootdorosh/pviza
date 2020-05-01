<template>
  <div>
    {{ getValue }}
  </div>
</template>

<script>

export default {
  name: 'RenderableDatetime',
  props: ['data', 'index', 'column'],
  computed: {
    getValue: function() {
      let value = this.data[this.column].replace('T', ' ').replace('.000Z', '');
      return value;
    },
  },
};
</script>
