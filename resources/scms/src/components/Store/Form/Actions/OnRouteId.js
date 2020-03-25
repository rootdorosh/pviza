import router from '@/Routes';

export default function({ commit }) {
  const id = router.currentRoute.params.id;

  if (id) {
    commit('setState', {
      model: {
        id
      }
    });
  }
}
