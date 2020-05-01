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
    <h2 class="page-title"><?= $open?> meta.title.index <?= $close?></h2>
    <widget>
      <index
        :tableId="tableId"
        :url="url"
        :columns="columns"
        :options="options"
        :modal="modal"
        :name="name" 
        @if ($model['uiStore'])
        linkCreate="/<?= $model['base_uri']?>/create" 
        @endif
canActionPath="<?= $model['permission']?>"
      />
    </widget>
  </div>
</template>

<script>
import Widget from '@/components/MainContent/MainContent';
import Index from '@/components/Index/Index';
import { mapState, mapActions, mapMutations } from 'vuex';

export default {
  name: '<?= $model['vue']['componentName']?>Index',
  components: { Widget, Index },
  computed: {
    ...mapState('<?= $model['vue']['stateName']?>Index', {
      meta: state => state.meta,
      tableId: state => state.tableId,
      url: state => state.url,
      columns: state => state.columns,
      options: state => state.options,
      modal: state => state.modal,
      name: state => state.name,
    }),
    ...mapState('Index', {
      ids: state => state.ids,
      isLoading: state => state.isLoading,
    }),
  },
  methods: {
    ...mapMutations('<?= $model['vue']['stateName']?>Index', ['setState']),
    ...mapActions('<?= $model['vue']['stateName']?>Index', ['onMeta']),
  },
  created() {
    this.onMeta();
    this.tableInit();
  },
};
</script>