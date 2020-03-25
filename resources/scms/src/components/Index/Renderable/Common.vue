<template>
  <div>
    {{ data[column] }}
  </div>
</template>

<script>

export default {
  name: 'RenderableCommon',
  props: ['data', 'index', 'column'],
};
</script>
