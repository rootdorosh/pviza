<template>
  <div>
    <h2 class="page-title">{{ meta.title.updating }}</h2>
    <widget>
      <category-form />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import CategoryForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'BlogCategoryUpdate',
  components: { Widget, CategoryForm },
  computed: {
    ...mapState('blogCategoryForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('blogCategoryForm', ['setDefaultState']),
  },  
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }        
  
};
</script>
