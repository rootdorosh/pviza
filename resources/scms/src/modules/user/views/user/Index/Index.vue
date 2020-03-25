<template>
  <div>
    <h2 class="page-title">{{ meta.title.index }}</h2>
    <main-content>
      <index
        :canEditable="canEditAndDescroy"
        :canDestrable="canEditAndDescroy"
        :tableId="tableId"
        :url="url"
        :columns="columns"
        :options="options"
        :modal="modal"
        :name="name"
        linkCreate="/user/users/create"
        canActionPath="user.user"
      />
    </main-content>
  </div>
</template>

<script>
import Index from '@/components/Index/Index';
import { mapState, mapActions, mapMutations } from 'vuex';

export default {
  name: 'Users',
  components: { Index },
  computed: {
    ...mapState('userUsersIndex', {
      meta: state => state.meta,
      tableId: state => state.tableId,
      url: state => state.url,
      columns: state => state.columns,
      options: state => state.options,
      modal: state => state.modal,
      name: state => state.name,
    }),
    ...mapState('index', {
      ids: state => state.ids,
      isLoading: state => state.isLoading,
    }),
  },
  methods: {
    ...mapMutations('userUsersIndex', ['setState']),
    ...mapActions('userUsersIndex', ['onMeta']),
    canEditAndDescroy (row) {
      return row.id !== 1;
    },
  },
  created() {
    this.onMeta();
    this.tableInit();
  },
};
</script>
