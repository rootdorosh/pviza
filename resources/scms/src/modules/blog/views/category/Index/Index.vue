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
                linkCreate="/blog/categories/create" 
        canActionPath="blog.category"
      />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import Index from '@/components/Index/Index';
import { mapState, mapActions, mapMutations } from 'vuex';

export default {
  name: 'BlogCategoryIndex',
  components: { Widget, Index },
  computed: {
    ...mapState('blogCategoryIndex', {
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
    ...mapMutations('blogCategoryIndex', ['setState']),
    ...mapActions('blogCategoryIndex', ['onMeta']),
  },
  created() {
    this.onMeta();
    this.tableInit();
  },
};
</script>