<template>
  <div>
    <h2 class="page-title">{{ meta.title.creating }}</h2>
    <main-content>
      <user-form />
    </main-content>
  </div>
</template>

<script>
import UserForm from '@/modules/user/views/user/Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'UserCreate',
  components: { UserForm },
  computed: {
    ...mapState('userUsersForm', {
      meta: state => state.meta,
    }),
  },
};
</script>
