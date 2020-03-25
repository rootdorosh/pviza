export const FormElementsHelper = {
  methods: {

    fieldChange(field, value) {
      let model = {};

      model[field] = value;

      this.setState({
        model
      });
    },

    selectChange(field, data) {
      let value = [];

      for (let key in data) {
        value.push(data[key].val);
      }

      this.fieldChange(field, value);
    },

    nodesRefresh(data) {
      for(let key in data) {
        this.$refs[key].$el.ej2_instances[0].fields = this.nodes[key];
      }
    },

    fieldState(field, isMessage = false) {
      const error = this.errorMessage[field];

      if (isMessage) {
        return error ? error[0] : null;
      } else {
        return error ? false : null;
      }

      return null;
    },

  }
};
