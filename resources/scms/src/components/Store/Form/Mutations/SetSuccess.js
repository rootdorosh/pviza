export default function(state, data = true) {
  state.isFetching = false;
  state.errorMessage = '';

  if (data) {
    let model = state.model;
    let image = state.image;
    let select = state.select;

    if (model) {
      for (let key in model) {
        model[key] = '';
      }
    }

    if (image) {
      for (let key in image) {
        image[key] = '';
      }
    }

    if (select) {
      for (let key in select) {
        for (let item in select[key]) {
          select[key][item] = [];
        }
      }
    }
  }
}
