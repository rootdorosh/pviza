import AdvantageCategoryIndex from './views/category/Index/Index'
import AdvantageCategoryCreate from './views/category/Create/Create'
import AdvantageCategoryUpdate from './views/category/Update/Update'
import AdvantageAdvantageIndex from './views/advantage/Index/Index'
import AdvantageAdvantageCreate from './views/advantage/Create/Create'
import AdvantageAdvantageUpdate from './views/advantage/Update/Update'

export default [
  {
    path: '/advantage/categories',
    name: 'advantageCategoryIndex',
    component: AdvantageCategoryIndex,
  },
  {
    path: '/advantage/categories/create',
    name: 'advantageCategoryCreate',
    component: AdvantageCategoryCreate,
  },
  {
    path: '/advantage/categories/:id',
    name: 'advantageCategoryUpdate',
    component: AdvantageCategoryUpdate,
  },
  {
    path: '/advantage/advantages',
    name: 'advantageAdvantageIndex',
    component: AdvantageAdvantageIndex,
  },
  {
    path: '/advantage/advantages/create',
    name: 'advantageAdvantageCreate',
    component: AdvantageAdvantageCreate,
  },
  {
    path: '/advantage/advantages/:id',
    name: 'advantageAdvantageUpdate',
    component: AdvantageAdvantageUpdate,
  }];