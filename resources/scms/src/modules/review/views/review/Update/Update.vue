<template>
  <div>
    <h2 class="page-title">{{ meta.title.updating }}</h2>
    <widget>
      <review-form />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import ReviewForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'ReviewReviewUpdate',
  components: { Widget, ReviewForm },
  computed: {
    ...mapState('reviewReviewForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('reviewReviewForm', ['setDefaultState']),
  },  
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }        
  
};
</script>
