import router from '@/Routes';

export default function({ state, commit }, data) {
  if (state.model.id) {
    commit('setSuccess', false);

    commit('alert/setAlert', {
      text: state.meta.success.updated,
      type: 'success',
      show: true,
      redirect: data == 'saveExit' ? true : false,
    }, { root: true });

    if (data == 'saveExit') {
      commit('setSuccess');
      router.push(state.url);
    }
  } else {
    commit('setSuccess');

    commit('alert/setAlert', {
      text: state.meta.success.created,
      type: 'success',
      show: true,
      redirect: true,
    }, { root: true });

    router.push(state.url);
  }
}
