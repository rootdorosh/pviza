<template v-if="meta.isLoaded">
  <div>
    <h2 class="page-title">{{ meta.title.updating }}</h2>
    <widget>
      <form @submit.prevent="onSubmit('save')">
        <b-tabs content-class="mt-3">
          <b-tab :title="tab.title" v-for="(tab, indexTab) in tabs">
            <b-form-group
              v-for="(field, index) in tab.fields"
              :label-for="index"
              :class="{'is-invalid': errors[index]}"
              :label="meta.fields[index]"
              label-cols-sm="4"
              >

              <b-form-radio-group
                v-if="field.type === 'checkbox'"
                v-model="model[index]"
                :options="optionsNoYes"
                buttons
                button-variant="outline-primary"
              />

              <b-form-select
                v-if="field.type === 'select'"
                v-model="model[index]"
                :options="field.options"
              />

              <b-form-input
                v-if="field.type === 'text'"
                v-model="model[index]"
              />

              <span class="text-danger"
                    v-if="errors[index]">
                  {{ errors[index][0] }}
              </span>

            </b-form-group>
          </b-tab>
        </b-tabs>

        <b-form-group class="form-action">
          <div class="btns-right">
            <b-button
              variant="primary"
              type="submit"
              class="btn-set"
              @click="onSubmit"
            >
            {{ $t('update') }}
            </b-button>
          </div>
        </b-form-group>
      </form>
    </widget>
  </div>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex'
import FormFooter from '@/components/FormFooter/FormFooter'
import Widget from '@/components/MainContent/MainContent';

export default {
  name: 'SettingsSettingsForm',
  components: { FormFooter, Widget },
  computed: {
    ...mapState('settingsSettingsForm', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,
      tabs: state => state.tabs,
    }),
  },
  methods: {
    ...mapMutations('settingsSettingsForm', ['setState']),
    ...mapActions('settingsSettingsForm', ['onMeta', 'onSubmit']),
  },
  created() {
    this.onMeta()
  },
}
</script>
