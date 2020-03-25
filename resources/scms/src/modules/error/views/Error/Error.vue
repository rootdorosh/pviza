<template>
  <div class="error-page">
    <b-container>
      <div class="errorContainer mx-auto">
        <h1 class="errorCode">404</h1>
        <p class="errorInfo">
          Opps, it seems that this page does not exist.
        </p>
        <p class="text-center">
          <router-link to="/" class="btn btn-inverse">{{ $t('back.home') }}</router-link>
        </p>
      </div>
      <footer class="pageFooter">
        {{ $t('copyright') }}
      </footer>
    </b-container>
  </div>
</template>

<script>
export default {
  name: 'Error'
};
</script>

<style src="./Error.scss" lang="scss" scoped />
