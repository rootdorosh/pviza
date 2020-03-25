export default function({ commit }, data) {
  commit('setState', {
    isFetching: data
  });
}
