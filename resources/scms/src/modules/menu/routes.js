import MenuIndex from './views/menu/Index/Index';
import MenuCreate from './views/menu/Create/Create';
import MenuUpdate from './views/menu/Update/Update';

export default [
  {
    path: '/menu/menus',
    name: 'MenuIndex',
    component: MenuIndex,
  },
  {
    path: '/menu/menus/create/:domainId',
    name: 'MenuCreate',
    component: MenuCreate,
  },
  {
    path: '/menu/menus/:id',
    name: 'MenuUpdate',
    component: MenuUpdate,
  },
];
