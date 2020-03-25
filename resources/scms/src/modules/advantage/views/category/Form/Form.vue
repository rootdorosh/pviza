<template>
  <div>
    <form @submit.prevent="onSubmit('save')">
      <b-tabs content-class="mt-3">
        <b-tab :title="$t('tab.main')" active>
         <b-form-group
           label-for="is_active"
           horizontal
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
           label-for="rank"
           horizontal
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

        </b-tab>

        <b-tab v-for="locale in getLocales()" :title="locale">
         <b-form-group
           :label="meta.fields.title"
           :label-for="locale + '-title'"
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
           :label="meta.fields.description"
           :label-for="locale + '-description'"
           :class="{'is-invalid': getErrorLocale('description', locale)}"
           label-cols-sm="2"
         >
           <b-form-textarea
             :id="locale + '-description'"
             v-model="model[locale].description"
           />
           <span class="text-danger" v-if="getErrorLocale('description', locale)">{{ getErrorLocale('description', locale) }}</span>
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
  name: 'AdvantageCategoryForm',
  components: { FormFooter, vSelect, InputFileBase64 },
  computed: {
    ...mapState('advantageCategoryForm', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,
    }),
  },
  methods: {
    ...mapMutations('advantageCategoryForm', ['setState']),
    ...mapActions('advantageCategoryForm', ['onMeta', 'onSubmit', 'onCancel', 'onSaveExit', 'onRouteId']),
  },
  created() {
    this.onRouteId();
    this.onMeta();
  },
  mounted() {
    
  },
  beforeDestroy: function() {
     
  },
};
</script>
