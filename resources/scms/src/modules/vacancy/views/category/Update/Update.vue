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
  name: 'VacancyCategoryUpdate',
  components: { Widget, CategoryForm },
  computed: {
    ...mapState('vacancyCategoryForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('vacancyCategoryForm', ['setDefaultState']),
  },  
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }        
  
};
</script>
