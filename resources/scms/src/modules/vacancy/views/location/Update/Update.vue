<template>
  <div>
    <h2 class="page-title">{{ meta.title.updating }}</h2>
    <widget>
      <location-form />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import LocationForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'VacancyLocationUpdate',
  components: { Widget, LocationForm },
  computed: {
    ...mapState('vacancyLocationForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('vacancyLocationForm', ['setDefaultState']),
  },  
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }        
  
};
</script>
