export const ModalHelper = {
  methods: {

    modalShow(modalId) {
      this.$bvModal.show(modalId);
    },

    modalHide(modalId) {
      this.$bvModal.hide(modalId);
    },

  }
};
