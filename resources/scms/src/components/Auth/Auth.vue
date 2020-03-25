<template>
  <div class="auth-page">
    <b-container>
      <h5 class="auth-logo">
        <i class="fa fa-circle text-gray"></i>
        {{ title }}
        <i class="fa fa-circle text-warning"></i>
      </h5>
      <slot></slot>
    </b-container>
    <footer class="auth-footer">
      {{ $t('copyright') }}
    </footer>
  </div>
</template>

<script>
export default {
  name: 'Auth',
  props: ['title']
}
</script>
