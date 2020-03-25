<template>
  <div>
    <span class="badge"
    v-bind:style="{ 'background-color': data[column]}">{{ data[column] }}</span>
</div>
</template>

<script>

export default {
  name: 'RenderableCheckbox',
  props: ['data', 'index', 'column'],
};
</script>
