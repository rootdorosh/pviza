<?php 
use \App\Services\ModuleGenerator\Formatter;
$enter = "\n";
$tab2 = "  ";
$tab4 = "    ";
$tab6 = "      ";
?>
import { TableHelper } from '@/mixins/TableHelper';
import cloneObject from '@/core/cloneObject';
import tableConfig from '@/core/tableConfig';
import { states, mutations, actions } from '@/components/Store/Index/Index';

const columns = <?= Formatter::arrayToVueJson($model['vue']['filter'])?>

const state = cloneObject(states);
const table = tableConfig(columns);

export default {
  namespaced: true,
  state: {
    ...state,
    name: '{{ $model['name_plural'] }}',
    url: '/{{ Str::kebab($model['base_uri']) }}',
    columns: table.columns,
    options: {
      ...table.options,
    },
  },
  mutations: {
    ...mutations,
  },
  actions: {
    ...actions,
  },
};