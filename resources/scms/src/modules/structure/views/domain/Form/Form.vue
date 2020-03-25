<template>
  <div>

    <form @submit.prevent="onSubmit('save')">
      <b-tabs content-class="mt-3">
        <b-tab :title="$t('tab.main')" active>
          <b-form-group
            label-for="alias"
            horizontal
            :label="meta.fields.alias"
            :description="meta.description.alias"
            :label-cols="2"
          >
            <b-form-input
              type="text"
              name="alias"
              id="alias"
              v-model="model.alias"
            />
            <span class="text-danger" v-if="errors.alias">
              {{ errors.alias[0] }}
            </span>
          </b-form-group>

          <b-form-group
            label-for="is-active"
            horizontal
            :label="meta.fields.is_active"
            :description="meta.description.is_active"
            :label-cols="2"
          >
            <b-form-radio-group
              id="is-active"
              name="is_active"
              :options="optionsNoYes"
              buttons
              button-variant="outline-primary"
              v-model="model.is_active"
            />
            <span class="text-danger" v-if="errors.is_active">
              {{ errors.is_active[0] }}
            </span>
          </b-form-group>

          <b-form-group
            label-for="site_langs"
            horizontal
            :label="meta.fields.site_langs"
            :description="meta.description.site_langs"
            :label-cols="2"
          >
            <v-select
              id="roles"
              :options="meta.options.languages"
              multiple
              v-model="model.site_langs"
            >
              <div slot="no-options">{{ $t('select.no.options') }}</div>
            </v-select>
            <span class="text-danger" v-if="errors.site_langs">
              {{ errors.site_langs[0] }}
            </span>
          </b-form-group>

          <b-form-group
            label-for="site_lang"
            horizontal
            :label="meta.fields.site_lang"
            :description="meta.description.site_lang"
            :label-cols="2"
          >
            <v-select
              id="roles"
              :options="meta.options.languages"
              v-model="model.site_lang"
            >
              <div slot="no-options">{{ $t('select.no.options') }}</div>
            </v-select>
            <span class="text-danger" v-if="errors.site_lang">
              {{ errors.site_lang[0] }}
            </span>
          </b-form-group>

          <b-form-group
            label-for="logo"
            horizontal
            :label="meta.fields.logo"
            label-cols-sm="4"
          >
            <input-file-base64
              name="logo"
              v-model="model.logo"
              :value="model.logo"
            />
            <span class="text-danger" v-if="errors.logo">
              {{ errors.logo[0] }}
            </span>
          </b-form-group>
        </b-tab>

        <!-- tabs locale -->
        <b-tab v-for="locale in getLocales()" :title="locale">
          <b-form-group
            :label="meta.fields.copyright"
            :label-for="locale + '-copyright'"
            :class="{'is-invalid': getErrorLocale('copyright', locale)}"
            label-cols-sm="2"
            >
            <b-form-input
              :id="locale + '-copyright'"
              v-model="model[locale].copyright"
              @keyup.enter="onSubmit('save')"  />
            <span class="text-danger"
              v-if="getErrorLocale('copyright', locale)">
              {{ getErrorLocale('copyright', locale) }}
            </span>
          </b-form-group>
        </b-tab>
      </b-tabs>
      
      <form-footer
        :model="model"
        :isFetching="isFetching"
        @onCancel="onCancel"
        @onSaveExit="onSaveExit"
      />
    </form>

  </div>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex';
import FormFooter from '@/components/FormFooter/FormFooter';
import vSelect from 'vue-select';
import InputFileBase64 from '@/components/FormElements/InputFilePreview/InputFileBase64';
import { bus } from '@/main';

export default {
  name: 'StructureDomainForm',
  components: { FormFooter, vSelect, InputFileBase64 },
  computed: {
    ...mapState('structureDomainForm', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,
    }),
  },
  methods: {
    ...mapMutations('structureDomainForm', ['setState']),
    ...mapActions('structureDomainForm', ['onMeta', 'onSubmit', 'onCancel', 'onSaveExit', 'onRouteId']),
  },
  created() {
    this.onRouteId();
    this.onMeta();
  },
  mounted() {
    bus.$on('file-change-logo', (data, isDelete) => {
      this.setState({
        model: {
          logo: data.content,
          logo_name: data.name,
          logo_delete: isDelete ? 1 : 0,
        }
      });
    })
  },
  beforeDestroy: function() {
    bus.$off('file-change-logo')
  },
};
</script>
