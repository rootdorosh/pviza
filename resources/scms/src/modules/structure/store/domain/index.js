import { TableHelper } from '@/mixins/TableHelper';
import cloneObject from '@/core/cloneObject';
import tableConfig from '@/core/tableConfig';
import { states, mutations, actions } from '@/components/Store/Index/Index';

const columns = {
  id: {},
  logo: {
    sortable: false,
    filterable: false,
    renderable: 'image',
  },
  alias: {},
  is_active: {
    filterable: TableHelper.methods.tableOptionsNoYes(),
    renderable: 'checkbox',
  },
  site_lang: {
    filterable: true,
  },
  site_langs: {
    sortable: false,
    filterable: false,
    renderable: 'array-secondary',
  },
  copyright: {},
};

const state = cloneObject(states);
const table = tableConfig(columns);

export default {
  namespaced: true,
  state: {
    ...state,
    name: 'domains',
    url: '/structure/domains',
    columns: table.columns,
    options: {
      ...table.options,
    },
    addtActions: [
      {
        icon: 'menu-hamburger',
        permission: 'structure.page.index',
        title: 'Domain structure',
        url: function (row) {
          return '/structure/domains/' + row.id + '/pages';
        }
      },
      {
        icon: 'th-list',
        permission: 'menu.menu.store',
        title: 'Create menu',
        url: function (row) {
          return '/menu/menus/create/' + row.id;
        }
      }
    ],
  },
  mutations: {
    ...mutations,
  },
  actions: {
    ...actions,
  },
};
