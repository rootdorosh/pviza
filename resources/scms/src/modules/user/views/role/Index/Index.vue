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
        linkCreate="/user/roles/create"
        canActionPath="user.role"
      />
    </main-content>
  </div>
</template>

<script>
import Index from '@/components/Index/Index';
import { mapState, mapActions, mapMutations } from 'vuex';

export default {
  name: 'Roles',
  components: { Index },
  computed: {
    ...mapState('userRolesIndex', {
      meta: state => state.meta,
      adminId: state => state.adminId,
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
    ...mapMutations('userRolesIndex', ['setState']),
    ...mapActions('userRolesIndex', ['onMeta']),
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
