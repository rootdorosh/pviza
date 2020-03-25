import Roles from './views/role/Index/Index';
import RoleCreate from './views/role/Create/Create';
import RoleUpdate from './views/role/Update/Update';
import RoleStore from './store/role/index';
import Users from './views/user/Index/Index';
import UserCreate from './views/user/Create/Create';
import UserUpdate from './views/user/Update/Update';
import UserStore from './store/user/index';

export default [
  {
    path: '/user/roles',
    name: 'Roles',
    component: Roles,
  },
  {
    path: '/user/roles/create',
    name: 'RoleCreate',
    component: RoleCreate,
  },
  {
    path: '/user/roles/:id',
    name: 'RoleUpdate',
    component: RoleUpdate,
    beforeEnter: (to, from, next) => {
      to.params.id != RoleStore.state.adminId ? next() : next({ path: '/404' });
    }
  },
  {
    path: '/user/users',
    name: 'Users',
    component: Users,
  },
  {
    path: '/user/users/create',
    name: 'UserCreate',
    component: UserCreate,
  },
  {
    path: '/user/users/:id',
    name: 'UserUpdate',
    component: UserUpdate,
    beforeEnter: (to, from, next) => {
      to.params.id != UserStore.state.adminId ? next() : next({ path: '/404' });
    }
  },
];
