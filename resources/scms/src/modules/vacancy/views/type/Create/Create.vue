<template>
  <div>
    <h2 class="page-title">{{ meta.title.creating }}</h2>
    <widget>
        <type-form />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import TypeForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'VacancyTypeCreate',
  components: { Widget, TypeForm },
  computed: {
    ...mapState('vacancyTypeForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('vacancyTypeForm', ['setDefaultState']),
  },  
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }        
};
</script>
