<template>
  <div>
    <h2 class="page-title">{{ meta.menu.title.creating }} - {{ domain.alias }}</h2>
    <main-content>
        <MenuForm />
    </main-content>
  </div>
</template>

<script>
import MenuForm from '@/modules/menu/views/menu/Form/MenuForm';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'MenuCreate',
  components: { MenuForm },
  computed: {
    ...mapState('menuForm', {
      meta: state => state.meta,
      domain: state => state.domain,
    }),
  },
  methods: {
    ...mapMutations('menuForm', ['setDefaultState']),
  },
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }
};
</script>
