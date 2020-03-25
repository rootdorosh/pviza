<template>
  <section class="widget" ref="widget">
    <Alert
      :data="alert"
    />
    <slot></slot>
  </section>
</template>

<script>
import Alert from '@/components/Alert/Alert';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'MainContent',
  components: { Alert },
  computed: {
    ...mapState('alert', {
      alert: state => state.alert,
    }),
  },
};
</script>

<style src="./MainContent.scss" lang="scss" />
