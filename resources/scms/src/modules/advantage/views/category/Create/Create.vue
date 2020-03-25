<template>
  <div>
    <h2 class="page-title">{{ meta.title.creating }}</h2>
    <main-content>
        <category-form />
    </main-content>
  </div>
</template>

<script>
import CategoryForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'AdvantageCategoryCreate',
  components: { CategoryForm },
  computed: {
    ...mapState('advantageCategoryForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('advantageCategoryForm', ['setDefaultState']),
  },
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }
};
</script>
