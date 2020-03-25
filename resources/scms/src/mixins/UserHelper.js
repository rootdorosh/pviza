export const UserHelper = {
  methods: {

    canAction(data) {
      if (data) {
        let type = typeof data;
        let actions = this.$user.permissions;

        if (type === 'string') {
          if (actions.includes(data)) {
            return true;
          }
        } else if (type === 'object') {
          let result = data.filter(function(e) {
            return Object.values(actions).includes(e);
          });

          if (result.length === data.length) {
            return true;
          }
        }
      }

      return false;
    },

    /**
     * @param {array} items
     * @returns {boolean}
     */
    canActions(items) {
      for (let key in items) {
        if (this.canAction(items[key])) {
          return true
        }
      }
      return false
    }

  }
};
