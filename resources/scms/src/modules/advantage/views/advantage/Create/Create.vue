<template>
  <div>
    <h2 class="page-title">{{ meta.title.creating }}</h2>
    <main-content>
        <advantage-form />
    </main-content>
  </div>
</template>

<script>
import AdvantageForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'AdvantageAdvantageCreate',
  components: { AdvantageForm },
  computed: {
    ...mapState('advantageAdvantageForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('advantageAdvantageForm', ['setDefaultState']),
  },
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }
};
</script>
