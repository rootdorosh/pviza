<template v-if="meta.isLoaded">
  <div>
    <form @submit.prevent="onSubmit('save')">
      <b-tabs content-class="mt-3">
        <b-tab :title="$t('tab.main')" :title-link-class="hasErrorsInTabMain() ? 'error':''" active>
         <b-form-group
           label-for="slug"
           horizontal
           label-class="required"
           :label="meta.fields.slug"
           :description="meta.description.slug"
           :label-cols="2"
         > 
           <b-form-input
             type="text"
             id="slug"
             v-model="model.slug"
           />
           <span class="text-danger" v-if="errors.slug">{{ errors.slug[0] }}</span>
         </b-form-group>

        </b-tab>


        <b-tab v-for="locale in getLocales()" :title="locale" :title-link-class="hasErrorsInTabLocale(locale) ? 'error':''">
         <b-form-group
           :label="meta.fields.value"
           :label-for="locale + '-value'"
           label-class="required"
           :class="{'is-invalid': getErrorLocale('value', locale)}"
           label-cols-sm="2"
         >
           <b-form-input
             type="text"
             :id="locale + '-value'"
             v-model="model[locale].value"
           />
           <span class="text-danger" v-if="getErrorLocale('value', locale)">{{ getErrorLocale('value', locale) }}</span>
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
import { mapState, mapActions, mapMutations } from 'vuex'
import FormFooter from '@/components/FormFooter/FormFooter'
import vSelect from 'vue-select'
import ImageBase64 from '@/components/FormElements/InputFilePreview/ImageFileBase64'

export default {
  name: 'TranslationTranslationForm',
  components: { FormFooter, vSelect, ImageBase64 },
  computed: {
    ...mapState('translationTranslationForm', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,
    }),
  },
  methods: {
    ...mapMutations('translationTranslationForm', ['setState']),
    ...mapActions('translationTranslationForm', ['onMeta', 'onSubmit', 'onCancel', 'onSaveExit', 'onRouteId']),
  },
  created() {
    this.onRouteId()
    this.onMeta()
  },
}
</script>
