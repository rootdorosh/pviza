<template>
  <div>
    <b-form-group class="form-action">
      <div class="btns-left">
        <b-button
          variant="default"
          class="btn-set"
          @click.prevent="onCancel"
        >
          {{ $t('cancel') }}
        </b-button>
      </div>
      <div class="btns-right">
        <b-button
          variant="primary"
          type="submit"
          class="btn-set"
          v-if="model.id"
        >
          {{ isFetching == 'save' ? $t('loading') : $t('save') }}
        </b-button>

        <b-button
          variant="primary"
          class="btn-set"
          @click.prevent="onSaveExit"
        >
          {{ isFetching == 'saveExit' ? $t('loading') : $t('save.exit') }}
        </b-button>
      </div>
    </b-form-group>
  </div>
</template>

<script>
export default {
  name: 'FormFooter',
  props: ['model', 'isFetching'],
  methods: {
    onCancel() {
      this.$emit('onCancel');
    },
    onSaveExit() {
      this.$emit('onSaveExit');
    },
  },
};
</script>
