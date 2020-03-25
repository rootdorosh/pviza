<template>
  <div>
    <b-badge class="badge-row" variant="success" v-if="data[column]">{{ $t('yes') }}</b-badge>
    <b-badge class="badge-row" variant="secondary" v-else>{{ $t('no') }}</b-badge>
  </div>
</template>

<script>

export default {
  name: 'RenderableCheckbox',
  props: ['data', 'index', 'column'],
};
</script>
