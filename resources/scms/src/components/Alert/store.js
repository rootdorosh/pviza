export default {
  namespaced: true,
  state: {
    alert: {
      type: '',
      text: '',
      show: false,
      redirect: false,
    },
  },
  mutations: {
    setAlert(state, data) {
      for (let key in data) {
        state.alert[key] = data[key];
      }
    },
  },
};
