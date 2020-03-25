<template v-if="meta.isLoaded">
  <div>
    <form @submit.prevent="onSubmit('save')">
      <b-tabs content-class="mt-3">
        <b-tab :title="$t('tab.main')" :title-link-class="hasErrorsInTabMain() ? 'error':''" active>
         <b-form-group
           label-for="categories"
           horizontal
           label-class="required"
           :label="meta.fields.categories"
           :description="meta.description.categories"
           :label-cols="2"
         > 
           <select-multiple
               :options="meta.options.categories"
               v-model="model.categories"
           />
           <span class="text-danger" v-if="errors.categories">{{ errors.categories[0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="types"
           horizontal
           label-class="required"
           :label="meta.fields.types"
           :description="meta.description.types"
           :label-cols="2"
         > 
           <select-multiple
               :options="meta.options.types"
               v-model="model.types"
           />
           <span class="text-danger" v-if="errors.types">{{ errors.types[0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="locations"
           horizontal
           label-class="required"
           :label="meta.fields.locations"
           :description="meta.description.locations"
           :label-cols="2"
         > 
           <select-multiple
               :options="meta.options.locations"
               v-model="model.locations"
           />
           <span class="text-danger" v-if="errors.locations">{{ errors.locations[0] }}</span>
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
           label-for="is_popular"
           horizontal
           label-class="required"
           :label="meta.fields.is_popular"
           :description="meta.description.is_popular"
           :label-cols="2"
         > 
           <b-form-radio-group
             id="is_popular"
             :options="optionsNoYes"
             buttons
             button-variant="outline-primary"
             v-model="model.is_popular"
           />
           <span class="text-danger" v-if="errors.is_popular">{{ errors.is_popular[0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="rank"
           horizontal
           label-class="required"
           :label="meta.fields.rank"
           :description="meta.description.rank"
           :label-cols="2"
         > 
           <b-form-input
             type="text"
             id="rank"
             v-model="model.rank"
           />
           <span class="text-danger" v-if="errors.rank">{{ errors.rank[0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="date_posted"
           horizontal
           :label="meta.fields.date_posted"
           :description="meta.description.date_posted"
           :label-cols="2"
         > 
           <b-form-input
             type="text"
             id="date_posted"
             v-model="model.date_posted"
           />
           <span class="text-danger" v-if="errors.date_posted">{{ errors.date_posted[0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="hiring_organization"
           horizontal
           :label="meta.fields.hiring_organization"
           :description="meta.description.hiring_organization"
           :label-cols="2"
         > 
           <b-form-input
             type="text"
             id="hiring_organization"
             v-model="model.hiring_organization"
           />
           <span class="text-danger" v-if="errors.hiring_organization">{{ errors.hiring_organization[0] }}</span>
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
           :label="meta.fields.salary"
           :label-for="locale + '-salary'"
           :class="{'is-invalid': getErrorLocale('salary', locale)}"
           label-cols-sm="2"
         >
           <b-form-input
             type="text"
             :id="locale + '-salary'"
             v-model="model[locale].salary"
           />
           <span class="text-danger" v-if="getErrorLocale('salary', locale)">{{ getErrorLocale('salary', locale) }}</span>
         </b-form-group>

         <b-form-group
           :label="meta.fields.work_schedule"
           :label-for="locale + '-work_schedule'"
           :class="{'is-invalid': getErrorLocale('work_schedule', locale)}"
           label-cols-sm="2"
         >
           <b-form-input
             type="text"
             :id="locale + '-work_schedule'"
             v-model="model[locale].work_schedule"
           />
           <span class="text-danger" v-if="getErrorLocale('work_schedule', locale)">{{ getErrorLocale('work_schedule', locale) }}</span>
         </b-form-group>

         <b-form-group
           :label="meta.fields.contract_type"
           :label-for="locale + '-contract_type'"
           :class="{'is-invalid': getErrorLocale('contract_type', locale)}"
           label-cols-sm="2"
         >
           <b-form-input
             type="text"
             :id="locale + '-contract_type'"
             v-model="model[locale].contract_type"
           />
           <span class="text-danger" v-if="getErrorLocale('contract_type', locale)">{{ getErrorLocale('contract_type', locale) }}</span>
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
import SelectMultiple from '@/components/Form/SelectMultiple.vue'

export default {
  name: 'VacancyVacancyForm',
  components: { FormFooter, ImageBase64, SelectMultiple },
  computed: {
    ...mapState('vacancyVacancyForm', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,  
    }),
  },
  methods: {
    ...mapMutations('vacancyVacancyForm', ['setState']),
    ...mapActions('vacancyVacancyForm', ['onMeta', 'onSubmit', 'onCancel', 'onSaveExit', 'onRouteId']),
  },
  created() {
    this.onRouteId()
    this.onMeta()
  },
}
</script>
