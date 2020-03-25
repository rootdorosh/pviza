export default function({ state, commit }) {
  axios
    .get(state.url + '/meta')
    .then(response => {
      let labels = response.data.labels;
      let options = response.data.options;

      if (typeof options !== 'undefined') {
        let select = state.options.select;

        for (let key in select) {
          let selectOptions = options[select[key]];
          let value = [];

          console.log(selectOptions);

          for (let key in selectOptions) {
            let id = selectOptions[key].value;
            let text = selectOptions[key].text;

            value.push({id, text});
          }

          commit('setState', {
            options: {
              listColumns: {
                [key]: value
              }
            }
          });
        }
      }

      commit('setState', {
        meta: {
          success: {
            deleted: labels.success.deleted
          },
          title: {
            index: labels.title.index
          },
        }
      });

      commit('setState', {
        options: {
          headings: labels.fields
        }
      });
    })
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
