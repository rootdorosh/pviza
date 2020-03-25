<?php 
use Illuminate\Support\Str;
use App\Services\ModuleGenerator\Formatter;
$enter = "\n";
$tab2 = "  ";
$tab4 = "    ";
$tab6 = "      ";
$open = "{{";
$close = "}}";

?>

<template v-if="meta.isLoaded">
  <div>
    <form @submit.prevent="onSubmit('save')">
<?= $form?>        
      <form-footer
          :model="model"
          :isFetching="isFetching"
          @onCancel="onCancel"
          @onSaveExit="onSaveExit"
       />        
    </form>
  </div>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex'
@foreach ($components as $k => $v)
import {{ $k }} from '{{ $v }}'
@endforeach

export default {
  name: '<?= $model['vue']['componentName']?>Form',
  components: { {{ implode(', ', array_keys($components)) }} },
  computed: {
    ...mapState('<?= $model['vue']['stateName']?>Form', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,  
    }),
  },
  methods: {
    ...mapMutations('<?= $model['vue']['stateName']?>Form', ['setState']),
    ...mapActions('<?= $model['vue']['stateName']?>Form', ['onMeta', 'onSubmit', 'onCancel', 'onSaveExit', 'onRouteId']),
  },
  created() {
    this.onRouteId()
    this.onMeta()
  },
}
</script>
