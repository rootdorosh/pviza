import { TableHelper } from '@/mixins/TableHelper';
import cloneObject from '@/core/cloneObject';
import tableConfig from '@/core/tableConfig';
import { states, mutations, actions } from '@/components/Store/Index/Index';

const columns = {
  id: {},
  image: {
    renderable: 'image',
    filterable: false,
    sortable: false,
  },
  name: {},
  is_active: {
    renderable: 'checkbox',
    filterable: TableHelper.methods.tableOptionsNoYes(),
  },
  is_hide_editor: {
    renderable: 'checkbox',
    filterable: TableHelper.methods.tableOptionsNoYes(),
  },
  title: {},
}
const state = cloneObject(states);
const table = tableConfig(columns);

export default {
  namespaced: true,
  state: {
    ...state,
    name: 'ContentBlocks',
    url: '/content-block/content-blocks',
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