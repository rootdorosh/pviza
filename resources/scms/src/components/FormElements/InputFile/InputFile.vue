<template>
  <b-input-group class="fileinput fileinput-new">
    <input
      :id="name"
      type="file"
      :name="name"
      class="d-none"
      @change="onChange"
    />

    <label :for="name" class="form-control">
      <span>{{ file }}</span>
    </label>

    <b-input-group-append>
      <label
        :for="name"
        class="btn btn-default"
      >
        {{ $t('input.file.change') }}
      </label>

      <label
        class="btn btn-default"
        @click="onRemove"
        v-if="file.length"
      >
        {{ $t('input.file.remove') }}
      </label>
    </b-input-group-append>

  </b-input-group>
</template>

<script>
export default {
  name: 'input-file',
  props: {
    name: '',
    value: ''
  },
  data() {
    return {
      file: '',
    }
  },
  methods: {
    onChange(e) {
      this.file = e.target.files[0].name;
    },
    onRemove() {
      this.file = '';
    },
  },
}
</script>
