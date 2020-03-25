export default function({ dispatch }, data) {
  dispatch('onRequest', data.options);

  axios(data.config)
  .then(response => {
    dispatch('onSuccess', data.options);
  })
  .catch(error => {
    if (error.response) {
      dispatch('onFailure', error.response.data.errors);
    }
  });
}
