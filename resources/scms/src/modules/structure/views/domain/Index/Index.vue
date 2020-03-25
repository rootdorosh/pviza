<template>
  <div>
    <h2 class="page-title">{{ meta.title.index }}</h2>
    <main-content>
      <index
        :tableId="tableId"
        :url="url"
        :columns="columns"
        :options="options"
        :modal="modal"
        :name="name"
        :addtActions="addtActions"
        linkCreate="/structure/domains/create"
        canActionPath="structure.domain"
      />
    </main-content>
  </div>
</template>

<script>
import Index from '@/components/Index/Index';
import { mapState, mapActions, mapMutations } from 'vuex';

export default {
  name: 'StructureDomainIndex',
  components: { Index },
  computed: {
    ...mapState('structureDomainIndex', {
      addtActions: state => state.addtActions,
      meta: state => state.meta,
      adminId: state => state.adminId,
      tableId: state => state.tableId,
      url: state => state.url,
      columns: state => state.columns,
      options: state => state.options,
      modal: state => state.modal,
      name: state => state.name,
    }),
    ...mapState('Index', {
      ids: state => state.ids,
      isLoading: state => state.isLoading,
    }),
  },
  methods: {
    ...mapMutations('structureDomainIndex', ['setState']),
    ...mapActions('structureDomainIndex', ['onMeta']),
  },
  created() {
    this.onMeta();
    this.tableInit();
  },
};
</script>
