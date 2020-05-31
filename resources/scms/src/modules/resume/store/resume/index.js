import { TableHelper } from '@/mixins/TableHelper';
import cloneObject from '@/core/cloneObject';
import tableConfig from '@/core/tableConfig';
import { states, mutations, actions } from '@/components/Store/Index/Index';

const columns = {
  id: {},
  vacancy_title: {
    filterable: 'select',
    optionsKey: 'vacancies',
  },
  created_at: {
    renderable: 'datetime',
    filterable: false,
  },
  name: {
    filterable: true,
  },
  email: {
    filterable: true,
  },
  phone: {
    filterable: true,
  },
}
const state = cloneObject(states);
const table = tableConfig(columns);

export default {
  namespaced: true,
  state: {
    ...state,
    name: 'Resumes',
    url: '/resume/resumes',
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