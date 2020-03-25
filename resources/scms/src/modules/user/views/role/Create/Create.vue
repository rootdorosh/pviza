<template>
  <div>
    <h2 class="page-title">{{ meta.title.creating }}</h2>
    <main-content class="tabs-form">
      <role-form />
    </main-content>
  </div>
</template>

<script>
import RoleForm from '@/modules/user/views/role/Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'RoleCreate',
  components: { RoleForm },
  computed: {
    ...mapState('userRolesForm', {
      meta: state => state.meta,
    }),
  },
};
</script>
