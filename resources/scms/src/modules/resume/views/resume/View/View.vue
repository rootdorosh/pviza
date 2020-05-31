<template v-if="meta.isLoaded">
  <div>
    <h3>  {{ meta.title.singular }} # {{ model.id }}</h3>
    <table class="table table-bordered table-lg mt-lg mb-0">
      <tbody>
        <tr v-for="(item, index) in modelFiltered">
            <td>{{ meta.fields[index] }}</td>
            <td>
              <template v-if="index !=='document'">{{ item }}</template>
              <template v-else>
                <a v-if="item" :href="item">download</a>
              </template>
            </td>
        </tr>
      </tbody>
    </table>
    <div>
      <b-form-group class="form-action">
        <div class="btns-left">
          <b-button
            variant="default"
            class="btn-set"
            @click.prevent="onCancel"
          >
            {{ $t('back') }}          </b-button>
        </div>
      </b-form-group>
    </div>

  </div>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex'

export default {
  name: 'ResumeResumeView',
  computed: {
    ...mapState('resumeResumeView', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,
    }),
    modelFiltered: function() {
      const except = ['id'];
      return Object.keys(this.model)
        .filter(key => !except.includes(key))
        .reduce((obj, key) => {
          obj[key] = this.model[key];
          return obj;
        }, {});
    }
  },
  methods: {
    ...mapMutations('resumeResumeView', ['setState']),
    ...mapActions('resumeResumeView', ['onMeta', 'onCancel', 'onRouteId']),
  },
  created() {
    this.onRouteId()
    this.onMeta()
  },
}
</script>
