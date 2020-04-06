<template>
  <div>
    <h2 class="page-title">{{ meta.title.updating }}</h2>
    <widget>
      <blog-form />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import BlogForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'BlogBlogUpdate',
  components: { Widget, BlogForm },
  computed: {
    ...mapState('blogBlogForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('blogBlogForm', ['setDefaultState']),
  },  
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }        
  
};
</script>
