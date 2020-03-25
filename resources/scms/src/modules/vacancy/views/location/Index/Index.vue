<template>
  <div>
    <h2 class="page-title">{{ meta.title.index }}</h2>
    <widget>
      <index
        :tableId="tableId"
        :url="url"
        :columns="columns"
        :options="options"
        :modal="modal"
        :name="name" 
                linkCreate="/vacancy/locations/create" 
        canActionPath="vacancy.location"
      />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import Index from '@/components/Index/Index';
import { mapState, mapActions, mapMutations } from 'vuex';

export default {
  name: 'VacancyLocationIndex',
  components: { Widget, Index },
  computed: {
    ...mapState('vacancyLocationIndex', {
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
    ...mapMutations('vacancyLocationIndex', ['setState']),
    ...mapActions('vacancyLocationIndex', ['onMeta']),
  },
  created() {
    this.onMeta();
    this.tableInit();
  },
};
</script>