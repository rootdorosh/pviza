export default function({ state, commit, dispatch }) {
  let axiosAll = [
    axios.get(state.url + '/meta')
  ];

  if (state.model.id) {
    axiosAll.push(axios.get(state.url + '/' + state.model.id));
  }

  axios
    .all(axiosAll)
    .then(axios.spread((meta, form) => {
      dispatch('onMetaResponse', {
        meta,
        form
      });
    }))
    .catch(error => {
      if (error.response) {
        let errors = error.response.data.errors;

        commit('alert/setAlert', {
          text: errors[Object.keys(errors)[0]][0],
          type: 'danger',
          show: true,
          redirect: false,
        }, { root: true });
      }
    });
}
