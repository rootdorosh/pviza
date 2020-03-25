<template>
    <div>
        <v-select
          :options="formattedOptions"
          :multiple="true"
          v-model="selected"
          v-on:input="updateValue($event)">
        /></v-select>
    </div>
</template>

<script>

import vSelect from 'vue-select'

  export default {
    components: { vSelect },
    props: {
      options: {},
      value: {},
    },
    data () {
      return {
        selected:[],
      }
    },
    computed: {
      formattedOptions: function() {
        let options = []
        for (let i in this.options) {
          options.push({
            val: this.options[i].value,
            label: this.options[i].text
          })
        }
        return options;
      },
    },
    methods: {
      updateValue: function (value) {
        let selected = []
        for (let i in value) {
          selected.push(value[i].val)
        }
        this.$emit('input', selected)
      },
      updateSelected: function (value) {
        var selected = [];
        for (let k in this.formattedOptions) {
          for (let i in this.value) {
            if (this.formattedOptions[k].val == this.value[i]) {
              selected.push(this.formattedOptions[k])
            }
          }
        }
        this.selected = selected;
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
