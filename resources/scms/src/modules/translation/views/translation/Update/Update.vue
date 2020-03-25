<template>
  <div>
    <h2 class="page-title">{{ meta.title.updating }}</h2>
    <widget>
      <translation-form />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import TranslationForm from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: 'TranslationTranslationUpdate',
  components: { Widget, TranslationForm },
  computed: {
    ...mapState('translationTranslationForm', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('translationTranslationForm', ['setDefaultState']),
  },  
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }        
  
};
</script>
