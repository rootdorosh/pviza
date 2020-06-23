<template v-if="meta.isLoaded">
  <div>
    <form @submit.prevent="onSubmit('save')">
      <b-tabs content-class="mt-3">
        <b-tab :title="$t('tab.main')" :title-link-class="hasErrorsInTabMain() ? 'error':''" active>
         <b-form-group
           label-for="event_id"
           horizontal
           :label="meta.fields.event_id"
           :description="meta.description.event_id"
           :label-cols="2"
         >
           <b-form-input
             type="text"
             id="event_id"
             v-model="model.event_id"
             :disabled="true"
           />
           <span class="text-danger" v-if="errors.event_id">{{ errors.event_id[0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="content_type"
           horizontal
           label-class="required"
           :label="meta.fields.content_type"
           :description="meta.description.content_type"
           :label-cols="2"
         >
           <b-form-radio-group
             id="content_type"
             :options="formOptionsHelperForRadio(meta.options.content_types)"
             buttons
             button-variant="outline-primary"
             v-model="model.content_type"
           />
           <span class="text-danger" v-if="errors.content_type">{{ errors.content_type[0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="is_active"
           horizontal
           label-class="required"
           :label="meta.fields.is_active"
           :description="meta.description.is_active"
           :label-cols="2"
         >
           <b-form-radio-group
             id="is_active"
             :options="optionsNoYes"
             buttons
             button-variant="outline-primary"
             v-model="model.is_active"
           />
           <span class="text-danger" v-if="errors.is_active">{{ errors.is_active[0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="from_email"
           horizontal
           :label="meta.fields.from_email"
           :description="meta.description.from_email"
           :label-cols="2"
         >
           <b-form-input
             type="text"
             id="from_email"
             v-model="model.from_email"
           />
           <span class="text-danger" v-if="errors.from_email">{{ errors.from_email[0] }}</span>
         </b-form-group>

        </b-tab>


        <b-tab v-for="locale in getLocales()" :title="locale" :title-link-class="hasErrorsInTabLocale(locale) ? 'error':''">
         <b-form-group
           :label="meta.fields.subject"
           :label-for="locale + '-subject'"
           label-class="required"
           :class="{'is-invalid': getErrorLocale('subject', locale)}"
           label-cols-sm="2"
         >
           <b-form-input
             type="text"
             :id="locale + '-subject'"
             v-model="model[locale].subject"
           />
           <span class="text-danger" v-if="getErrorLocale('subject', locale)">{{ getErrorLocale('subject', locale) }}</span>
         </b-form-group>

         <b-form-group
           :label="meta.fields.from_name"
           :label-for="locale + '-from_name'"
           :class="{'is-invalid': getErrorLocale('from_name', locale)}"
           label-cols-sm="2"
         >
           <b-form-input
             type="text"
             :id="locale + '-from_name'"
             v-model="model[locale].from_name"
           />
           <span class="text-danger" v-if="getErrorLocale('from_name', locale)">{{ getErrorLocale('from_name', locale) }}</span>
         </b-form-group>

         <b-form-group
           :label="meta.fields.body"
           :label-for="locale + '-body'"
           label-class="required"
           :class="{'is-invalid': getErrorLocale('body', locale)}"
           label-cols-sm="2"
           :description="model.vars"
         >
           <vue-trix
             :id="locale + '-body'"
             v-model="model[locale].body"
           />
           <span class="text-danger" v-if="getErrorLocale('body', locale)">{{ getErrorLocale('body', locale) }}</span>
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
import VueTrix from 'vue-trix'

export default {
  name: 'EventEventForm',
  components: { FormFooter, vSelect, ImageBase64, VueTrix },
  computed: {
    ...mapState('eventEventForm', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,
    }),
  },
  methods: {
    ...mapMutations('eventEventForm', ['setState']),
    ...mapActions('eventEventForm', ['onMeta', 'onSubmit', 'onCancel', 'onSaveExit', 'onRouteId']),
  },
  created() {
    this.onRouteId()
    this.onMeta()
  },
}
</script>
