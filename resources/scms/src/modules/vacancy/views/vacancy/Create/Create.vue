<template>
  <div>
    <h2 class="page-title">{{ meta.title.creating }}</h2>
    <widget>
        <vacancy-form />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import VacancyForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'VacancyVacancyCreate',
  components: { Widget, VacancyForm },
  computed: {
    ...mapState('vacancyVacancyForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('vacancyVacancyForm', ['setDefaultState']),
  },  
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }        
};
</script>
