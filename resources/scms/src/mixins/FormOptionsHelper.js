export const FormOptionsHelper = {
  methods: {

    formOptionsHelperForRadio(items) {
      let options = [];
      for (let key in items) {
        options.push({
          value: key,
          text: items[key],
        })
      }
      console.log(items);
      console.log(options);
      return options
    }

  }
};
