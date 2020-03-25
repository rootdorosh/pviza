<template>
  <div>

    <div class="row"
         v-for="(size, key) in sizes"
         :key="key"
     >

      <div class="col-sm-7">
        <b-form-group
          :label-for="id + '-' + size"
          :label="size"
          :label-cols="2"
        >
          <image-base64
            :value="getSizeAttrLocalValue(size, 'image')"
            @input="update(size + '.image', $event)"
          />
        </b-form-group>
      </div>

      <div class="col-sm-3">
        <b-form-group
          :label-for="id + '-' + size + 'background_size'"
          :label-cols="0"
        >
        <b-form-select
          :id="id + '-' + size + 'background_size'"
          :value="getSizeAttrLocalValue(size, 'background_size')"
          @input="update(size + '.background_size', $event)"
          :options="optionsBackgroundSize"
        />
        </b-form-group>
      </div>

      <div class="col-sm-2">
        <b-form-group
          :label-for="id + '-' + size + 'align'"
          :label-cols="0"
        >
        <b-form-select
          :id="id + '-' + size + 'align'"
          :value="getSizeAttrLocalValue(size, 'align')"
          @input="update(size + '.align', $event)"
          :options="optionsAlign"
        />
        </b-form-group>
      </div>

      <div class="col-sm-12"><hr/></div>
    </div>

  </div>
</template>

<script>

import ImageBase64 from '@/components/FormElements/InputFilePreview/ImageFileBase64'
import { cloneDeep, tap, set } from 'lodash'

export default {
  name: 'AdaptiveImages',
  components: { ImageBase64 },
  props: {
    value: {
      //type: Object,
      required: true
    },

    modelName: {
      type: String,
      required: true
    },

    attributeName: {
      type: String,
      required: true
    },

    sizes: {
      required: true
    }
  },
  data: function () {
    return {
      optionsBackgroundSize: [
        {value: null, text: 'Background size'},
        {value: 1, text: 'auto'},
        {value: 2, text: 'cover'},
        {value: 3, text: 'contain'},
      ],
      optionsAlign: [
        {value: null, text: 'Align'},
        {value: 1, text: 'left top'},
        {value: 2 , text: 'left center'},
        {value: 3 , text: 'left bottom'},
        {value: 4 , text: 'right top'},
        {value: 5 , text: 'right center'},
        {value: 6 , text: 'right bottom'},
        {value: 7, text: 'center top'},
        {value: 8, text: 'center'},
        {value: 9, text: 'center bottom'},
      ],
    }
  },
  computed: {
    id: function() {
      return this.modelName + '-' + this.attributeName
    },

    local() {
      return this.value ? this.value : this.defaultValue
    },

    defaultValue() {
      let value = {}
      for (let k in this.sizes) {
        let size = this.sizes[k];
        value[k + '_image'] = null
        value[k + '_align'] = null
        value[k + '_background_size'] = null
      }
      return value
    }
  },
  methods: {
    getSizeAttrLocalValue(size, attr) {
      let key = size + '.' + attr
      return typeof this.value[key] !== 'undefined' ? this.value[key] : ''
    },
    update(key, value) {
      this.$emit('input', tap(cloneDeep(this.local), v => set(v, key, value)))
    },
  },
}
</script>

<style scoped>
</style>
