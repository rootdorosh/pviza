import axios from 'axios';

export default function clearCookie() {
  localStorage.removeItem('token');
  localStorage.removeItem('user');
  document.cookie = 'token=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
  axios.defaults.headers.common['Authorization'] = '';
}
