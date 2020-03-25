import { TableHelper } from '@/mixins/TableHelper';
import cloneObject from '@/core/cloneObject';
import tableConfig from '@/core/tableConfig';
import { states, mutations, actions } from '@/components/Store/Index/Index';

const columns = {
  id: {},
  event_subject: {},
  from_email: {},
  from_name: {},
  email_to: {},
  subject: {},
  body: {},
  status: {
    filterable: false
  },
  created_time: {
    filterable: false
  },
  sended_time: {
    filterable: false
  },
}
const state = cloneObject(states);
const table = tableConfig(columns);

export default {
  namespaced: true,
  state: {
    ...state,
    name: 'Queues',
    url: '/event/queue',
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
