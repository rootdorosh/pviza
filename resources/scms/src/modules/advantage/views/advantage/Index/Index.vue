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
        linkCreate="/advantage/advantages/create"
        canActionPath="advantage.advantage"
      />
    </main-content>
  </div>
</template>

<script>
import Index from '@/components/Index/Index';
import { mapState, mapActions, mapMutations } from 'vuex';

export default {
  name: 'AdvantageAdvantageIndex',
  components: { Index },
  computed: {
    ...mapState('advantageAdvantageIndex', {
      meta: state => state.meta,
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
    ...mapMutations('advantageAdvantageIndex', ['setState']),
    ...mapActions('advantageAdvantageIndex', ['onMeta']),
  },
  created() {
    this.onMeta();
    this.tableInit();
  },
};
</script>
