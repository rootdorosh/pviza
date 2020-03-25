<template>
  <div>
    <h2 class="page-title">{{ meta.title.updating }}</h2>
    <main-content class="tabs-form">
      <role-form />
    </main-content>
  </div>
</template>

<script>
import RoleForm from '@/modules/user/views/role/Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'RoleUpdate',
  components: { RoleForm },
  computed: {
    ...mapState('userRolesForm', {
      meta: state => state.meta,
    }),
  },
};
</script>
