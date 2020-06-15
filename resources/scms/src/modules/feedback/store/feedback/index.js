import { TableHelper } from '@/mixins/TableHelper';
import cloneObject from '@/core/cloneObject';
import tableConfig from '@/core/tableConfig';
import { states, mutations, actions } from '@/components/Store/Index/Index';

const columns = {
  id: {},
  name: {
    filterable: true,
  },
  email: {
    filterable: true,
  },
  phone: {
    filterable: true,
  },
  created_at: {
    renderable: 'datetime',
    filterable: false,
  },
}
const state = cloneObject(states);
const table = tableConfig(columns);

export default {
  namespaced: true,
  state: {
    ...state,
    name: 'Feedbacks',
    url: '/feedback/feedbacks',
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