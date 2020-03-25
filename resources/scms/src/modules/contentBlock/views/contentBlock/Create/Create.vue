<template>
  <div>
    <h2 class="page-title">{{ meta.title.creating }}</h2>
    <widget>
        <content-block-form />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import ContentBlockForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'ContentBlockContentBlockCreate',
  components: { Widget, ContentBlockForm },
  computed: {
    ...mapState('contentBlockContentBlockForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('contentBlockContentBlockForm', ['setDefaultState']),
  },  
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }        
};
</script>
