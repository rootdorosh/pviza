import { TableHelper } from '@/mixins/TableHelper';
import cloneObject from '@/core/cloneObject';
import tableConfig from '@/core/tableConfig';
import { states, mutations, actions } from '@/components/Store/Index/Index';

const columns = {
  id: {},
  name: {},
  is_active: {
    filterable: TableHelper.methods.tableOptionsNoYes(),
    renderable: 'checkbox',
  },
  email: {},
  position: {},
  created_at: {
    filterable: false,
  },
  updated_at: {
    filterable: false,
  },
  image: {
    sortable: false,
    filterable: false,
    renderable: 'image',
  },
  name_roles: {
    sortable: false,
    filterable: false,
  },
};

const state = cloneObject(states);
const table = tableConfig(columns);

export default {
  namespaced: true,
  state: {
    ...state,
    name: 'users',
    adminId: 1,
    url: '/user/users',
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
