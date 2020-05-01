<?php 
use Illuminate\Support\Str;
$enter = "\n";
$tab2 = "  ";
$tab4 = "    ";
$tab6 = "      ";
$open = "{{";
$close = "}}";
?>
<template>
  <div>
    <h2 class="page-title"><?= $open?> meta.title.creating <?= $close?></h2>
    <widget>
        <<?= Str::kebab($model['name'])?>-form />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import <?= $model['name']?>Form from './../Form/Form';
import { mapState, mapMutations } from 'vuex';

export default {
  name: '<?= $model['vue']['componentName']?>Create',
  components: { Widget, <?= $model['name']?>Form },
  computed: {
    ...mapState('<?= $model['vue']['stateName']?>Form', {
      meta: state => state.meta,
    }),
  },
  methods: {
    ...mapMutations('<?= $model['vue']['stateName']?>Form', ['setDefaultState']),
  },  
  created() {
    this.setDefaultState();
  },
  destroyed() {
    this.setDefaultState();
  }        
};
</script>
