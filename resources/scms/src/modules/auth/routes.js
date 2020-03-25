import Login from './views/Login/Login';
import RemindPassword from './views/RemindPassword/RemindPassword';

export default [
  {
    path: '/auth/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/auth/remind-password',
    name: 'RemindPassword',
    component: RemindPassword,
  }
];
