import router from '@/Routes';

export default function({ state, commit }) {
  commit('setSuccess');
  router.push(state.url);
}
