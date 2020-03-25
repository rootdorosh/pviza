export default function(state, data) {
  state.isFetching = false;
  state.errorMessage = data;
}
