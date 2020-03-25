<template>
    <div>

      <b-form-group
        horizontal
        :label-class="required ? 'required':''"
        :label="label"
        :description="description"
        :label-cols="2"
      >
        <b-form-radio-group
          :options="optionsNoYes"
          buttons
          button-variant="outline-primary"
          v-model="localValue"
          v-on:input="updateValue($event)"
        />
        <span class="text-danger" v-if="error">{{ error[0] }}</span>
      </b-form-group>

    </div>
</template>

<script>

export default {
    props: {
      value: {},
      label: {},
      error: {},
      description: {},
      required: {},
    },
    data () {
      return {
        localValue: '',
      }
    },
    methods: {
      updateValue: function (value) {
        this.localValue = value
        this.$emit('input', value)
      },
      updateSelected: function (value) {
        this.localValue = value;
      }
    },
    watch: {
      value: {
        handler() {
          this.updateSelected()
        },
        deep: true
      }
    }
  }
</script>
