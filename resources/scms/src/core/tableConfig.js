import cloneObject from '@/core/cloneObject';
import filterObject from '@/core/filterObject';
import arrayToObject from '@/core/arrayToObject';
import { states } from '@/components/Store/Index/Index';
import { i18n } from '@/lang';

export default function(obj) {
  const base = cloneObject(states);
  const baseColumns = base.columns;
  const baseKeys = Object.keys(base.columns);
  let data = {};

  data[baseKeys[0]] = baseColumns[baseKeys[0]];

  for (let key in obj) {
    data[key] = obj[key];
  }

  data[baseKeys[1]] = baseColumns[baseKeys[1]];

  const columns = Object.keys(data);
  const headings = arrayToObject(columns);

  const templates = {};
  const listColumns = {};
  const initFilters = {};
  const filterable = [];
  const sortable = [];
  const select = {};

  for (let key in obj) {
    if (typeof obj[key].renderable !== 'undefined') {
      templates[key] = 'renderable-' + obj[key].renderable;
    }

    if (typeof obj[key].filterable !== 'undefined' && typeof obj[key].filterable !== 'boolean') {
      if (obj[key].filterable == 'select') {
        listColumns[key] = [];
        select[key] = obj[key].optionsKey;
      } else {
        listColumns[key] = obj[key].filterable;
      }
    }

    if (typeof obj[key].sortable === 'undefined' || obj[key].sortable) {
      sortable.push(key);
    }

    if (typeof obj[key].filterable === 'undefined' || obj[key].filterable) {
      filterable.push(key);
      initFilters[key] = '';
    }
   }

   return {
    columns,
    options: {
      sortable,
      filterable,
      headings,
      initFilters,
      templates,
      listColumns,
      select,
    },
  }
}
