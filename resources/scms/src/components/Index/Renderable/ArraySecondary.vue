<template>
  <div>
    <template v-for="value in data[column]">
    <b-badge class="badge-row" variant="secondary">{{ value }}</b-badge>&nbsp;
  </template>
  </div>
</template>

<script>

export default {
  name: 'RenderableArraySecondary',
  props: ['data', 'index', 'column'],
};
</script>
