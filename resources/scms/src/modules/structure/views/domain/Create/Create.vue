<template>
  <div>
    <h2 class="page-title">{{ meta.title.creating }}</h2>
    <main-content>
      <domain-form />
    </main-content>
  </div>
</template>

<script>
import DomainForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'StructureDomainCreate',
  components: { DomainForm },
  computed: {
    ...mapState('structureDomainForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('structureDomainForm', ['setDefaultState']),
  },
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }
};
</script>
