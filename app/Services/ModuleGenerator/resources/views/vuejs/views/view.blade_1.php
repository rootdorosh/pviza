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
    <h3>  <?= $open?> meta.title.singular }} # <?= $open?> model.id <?= $close?></h3>
    <table class="table table-bordered table-lg mt-lg mb-0">
      <tbody>
        <tr v-for="(item, index) in modelFiltered">
            <td><?= $open?> meta.fields[index] <?= $close?></td>
            <td><?= $open?> item <?= $close?></td>
        </tr>
      </tbody>
    </table>
    <div>
      <b-form-group class="form-action">
        <div class="btns-left">
          <b-button
            variant="default"
            class="btn-set"
            @click.prevent="onCancel"
          >
            <?= $open?> $t('back') <?= $close?>
          </b-button>
        </div>
      </b-form-group>
    </div>

  </div>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex'

export default {
  name: '<?= $model['vue']['componentName']?>View',
  computed: {
    ...mapState('<?= $model['vue']['stateName']?>View', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,
    }),
    modelFiltered: function() {
      const except = ['id'];
      return Object.keys(this.model)
        .filter(key => !except.includes(key))
        .reduce((obj, key) => {
          obj[key] = this.model[key];
          return obj;
        }, {});
    }
  },
  methods: {
    ...mapMutations('<?= $model['vue']['stateName']?>View', ['setState']),
    ...mapActions('<?= $model['vue']['stateName']?>View', ['onMeta', 'onCancel', 'onRouteId']),
  },
  created() {
    this.onRouteId()
    this.onMeta()
  },
}
</script>
