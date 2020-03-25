<template>
  <div>
    <h2 class="page-title">{{ meta.title.updating }}</h2>
    <widget>
      <event-form />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import EventForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'EventEventUpdate',
  components: { Widget, EventForm },
  computed: {
    ...mapState('eventEventForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('eventEventForm', ['setDefaultState']),
  },  
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }        
  
};
</script>
