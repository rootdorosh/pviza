<template>
  <b-alert
    :variant="data.type"
    :show="data.show"
    :fade="true"
    dismissible
    @dismissed="onDismissed"
  >
    {{ data.text }}
  </b-alert>
</template>

<script>
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'Alert',
  props: {
    data: {}
  },
  data() {
    return {
      timeout: 3,
    }
  },
  methods: {
    ...mapMutations('alert', ['setAlert']),
    onDismissed() {
      this.setAlert({
        type: '',
        text: '',
        show: false,
        redirect: false,
      });
    },
  },
  created () {
    if (this.data.redirect) {
      this.setAlert({
        redirect: false,
      });
    } else {
      this.setAlert({
        type: '',
        text: '',
        show: false,
        redirect: false,
      });
    }
  },
  watch: {
    data: {
      handler(data) {
        if (data.show && typeof data.show === 'boolean') {
          this.setAlert({
            show: this.timeout,
          });
        }
      },
      deep: true
    },
  },
}
</script>
