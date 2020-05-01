<template v-if="meta.isLoaded">
  <div>
      
      
    <form @submit.prevent="onSubmit('save')">
      <b-tabs content-class="mt-3">
        <b-tab :title="$t('tab.main')" :title-link-class="hasErrorsInTabMain() ? 'error':''" active>
         <b-form-group
           label-for="category_id"
           horizontal
           label-class="required"
           :label="meta.fields.category_id"
           :description="meta.description.category_id"
           :label-cols="2"
         > 
           <b-form-select
             id="category_id"
             v-model="model.category_id"
             :options="meta.options.categories"
           />
           <span class="text-danger" v-if="errors.category_id">{{ errors.category_id[0] }}</span>
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
           label-for="is_home"
           horizontal
           label-class="required"
           :label="meta.fields.is_home"
           :description="meta.description.is_home"
           :label-cols="2"
         > 
           <b-form-radio-group
             id="is_home"
             :options="optionsNoYes"
             buttons
             button-variant="outline-primary"
             v-model="model.is_home"
           />
           <span class="text-danger" v-if="errors.is_home">{{ errors.is_home[0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="image"
           horizontal
           :label="meta.fields.image"
           :description="meta.description.image"
           :label-cols="2"
         > 
           <image-base64 v-model="model.image" />
           <span class="text-danger" v-if="errors['image.content']">{{ errors['image.content'][0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="image_header"
           horizontal
           :label="meta.fields.image_header"
           :description="meta.description.image_header"
           :label-cols="2"
         > 
           <image-base64 v-model="model.image_header" />
           <span class="text-danger" v-if="errors['image_header.content']">{{ errors['image_header.content'][0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="created_at"
           horizontal
           label-class="required"
           :label="meta.fields.created_at"
           :description="meta.description.created_at"
           :label-cols="2"
         > 
           <datetime
             type="datetime"
             format="yyyy-MM-dd HH:mm:ss"
             id="created_at"
             v-model="model.created_at"
             :auto="true"
           />
           <span class="text-danger" v-if="errors.created_at">{{ errors.created_at[0] }}</span>
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
           :label="meta.fields.alias"
           :label-for="locale + '-alias'"
           :class="{'is-invalid': getErrorLocale('alias', locale)}"
           label-cols-sm="2"
         >
           <b-form-input
             type="text"
             :id="locale + '-alias'"
             v-model="model[locale].alias"
           />
           <span class="text-danger" v-if="getErrorLocale('alias', locale)">{{ getErrorLocale('alias', locale) }}</span>
         </b-form-group>

         <b-form-group
           :label="meta.fields.description"
           :label-for="locale + '-description'"
           :class="{'is-invalid': getErrorLocale('description', locale)}"
           label-cols-sm="2"
         >
           <mavon-editor
             :id="locale + '-description'"
             v-model="model[locale].description"
           />
           <span class="text-danger" v-if="getErrorLocale('description', locale)">{{ getErrorLocale('description', locale) }}</span>
         </b-form-group>

         <b-form-group
           :label="meta.fields.seo_h1"
           :label-for="locale + '-seo_h1'"
           :class="{'is-invalid': getErrorLocale('seo_h1', locale)}"
           label-cols-sm="2"
         >
           <b-form-input
             type="text"
             :id="locale + '-seo_h1'"
             v-model="model[locale].seo_h1"
           />
           <span class="text-danger" v-if="getErrorLocale('seo_h1', locale)">{{ getErrorLocale('seo_h1', locale) }}</span>
         </b-form-group>

         <b-form-group
           :label="meta.fields.seo_title"
           :label-for="locale + '-seo_title'"
           :class="{'is-invalid': getErrorLocale('seo_title', locale)}"
           label-cols-sm="2"
         >
           <b-form-input
             type="text"
             :id="locale + '-seo_title'"
             v-model="model[locale].seo_title"
           />
           <span class="text-danger" v-if="getErrorLocale('seo_title', locale)">{{ getErrorLocale('seo_title', locale) }}</span>
         </b-form-group>

         <b-form-group
           :label="meta.fields.seo_description"
           :label-for="locale + '-seo_description'"
           :class="{'is-invalid': getErrorLocale('seo_description', locale)}"
           label-cols-sm="2"
         >
           <b-form-input
             type="text"
             :id="locale + '-seo_description'"
             v-model="model[locale].seo_description"
           />
           <span class="text-danger" v-if="getErrorLocale('seo_description', locale)">{{ getErrorLocale('seo_description', locale) }}</span>
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
import ImageBase64 from '@/components/FormElements/InputFilePreview/ImageFileBase64'

export default {
  name: 'BlogBlogForm',
  components: { FormFooter, ImageBase64 },
  computed: {
    ...mapState('blogBlogForm', {
      meta: state => state.meta,
    
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,  
    }),
  },
  methods: {
    ...mapMutations('blogBlogForm', ['setState']),
    ...mapActions('blogBlogForm', ['onMeta', 'onSubmit', 'onCancel', 'onSaveExit', 'onRouteId']),
  },
  created() {
    this.onRouteId()
    this.onMeta()
  },
}
</script>
