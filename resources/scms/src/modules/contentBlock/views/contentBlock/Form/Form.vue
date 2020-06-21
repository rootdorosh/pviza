<template v-if="meta.isLoaded">
  <div>

    <form @submit.prevent="onSubmit('save')">
      <b-tabs content-class="mt-3">
        <b-tab :title="$t('tab.main')" :title-link-class="hasErrorsInTabMain() ? 'error':''" active>
         <b-form-group
           label-for="image"
           horizontal
           :label="meta.fields.image"
           :description="meta.description.image"
           :label-cols="2"
         >
           <image-base64 v-model="model.image" />
           <span class="text-danger" v-if="errors.image_content">{{ errors.image_content[0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="name"
           horizontal
           label-class="required"
           :label="meta.fields.name"
           :description="meta.description.name"
           :label-cols="2"
         >
           <b-form-input
             type="text"
             id="name"
             v-model="model.name"
           />
           <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
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
           label-for="is_hide_editor"
           horizontal
           label-class="required"
           :label="meta.fields.is_hide_editor"
           :description="meta.description.is_hide_editor"
           :label-cols="2"
         >
           <b-form-radio-group
             id="is_hide_editor"
             :options="optionsNoYes"
             buttons
             button-variant="outline-primary"
             v-model="model.is_hide_editor"
           />
           <span class="text-danger" v-if="errors.is_hide_editor">{{ errors.is_hide_editor[0] }}</span>
         </b-form-group>

        </b-tab>


        <b-tab v-for="locale in getLocales()" :title="locale" :title-link-class="hasErrorsInTabLocale(locale) ? 'error':''">
         <b-form-group
           :label="meta.fields.title"
           :label-for="locale + '-title'"
           label-class="required"
           :class="{'is-invalid': getErrorLocale('title', locale)}"
           label-cols-sm="2"
         >
           <b-form-input
             type="text"
             :id="locale + '-title'"
             v-model="model[locale].title"
           />
           <span class="text-danger" v-if="getErrorLocale('title', locale)">{{ getErrorLocale('title', locale) }}</span>
         </b-form-group>

         <b-form-group
           :label="meta.fields.body"
           :label-for="locale + '-body'"
           label-class="required"
           :class="{'is-invalid': getErrorLocale('body', locale)}"
           label-cols-sm="2"
         >

             <vue-trix
                 :id="locale + '-body'"
                 v-model="model[locale].body"
                 v-if="!model.is_hide_editor"
             />


           <b-form-textarea
             :id="locale + '-body'"
             v-model="model[locale].body"
             v-if="model.is_hide_editor"
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
import ListGrid from '@/components/ListGrid/index.vue'
import AdaptiveImages from '@/components/AdaptiveImages/index.vue'
import VueTrix from 'vue-trix'

export default {
  name: 'ContentBlockContentBlockForm',
  components: { FormFooter, vSelect, ImageBase64, ListGrid, AdaptiveImages, VueTrix },
  computed: {
    ...mapState('contentBlockContentBlockForm', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,
    }),
  },
  methods: {
    ...mapMutations('contentBlockContentBlockForm', ['setState']),
    ...mapActions('contentBlockContentBlockForm', ['onMeta', 'onSubmit', 'onCancel', 'onSaveExit', 'onRouteId']),
  },
  created() {
    this.onRouteId()
    this.onMeta()
  },
}
</script>
