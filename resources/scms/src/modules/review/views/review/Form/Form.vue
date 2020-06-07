<template v-if="meta.isLoaded">
  <div>
      
      
    <form @submit.prevent="onSubmit('save')">
      <b-tabs content-class="mt-3">
        <b-tab :title="$t('tab.main')" :title-link-class="hasErrorsInTabMain() ? 'error':''" active>
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
           label-for="email"
           horizontal
           label-class="required"
           :label="meta.fields.email"
           :description="meta.description.email"
           :label-cols="2"
         > 
           <b-form-input
             type="text"
             id="email"
             v-model="model.email"
           />
           <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
         </b-form-group>

         <b-form-group
           label-for="comment"
           horizontal
           label-class="required"
           :label="meta.fields.comment"
           :description="meta.description.comment"
           :label-cols="2"
         > 
           <b-form-textarea
             id="comment"
             v-model="model.comment"
           />
           <span class="text-danger" v-if="errors.comment">{{ errors.comment[0] }}</span>
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
  name: 'ReviewReviewForm',
  components: { FormFooter, ImageBase64 },
  computed: {
    ...mapState('reviewReviewForm', {
      meta: state => state.meta,
    
      model: state => state.model,
      isFetching: state => state.isFetching,
      errors: state => state.errorMessage,  
    }),
  },
  methods: {
    ...mapMutations('reviewReviewForm', ['setState']),
    ...mapActions('reviewReviewForm', ['onMeta', 'onSubmit', 'onCancel', 'onSaveExit', 'onRouteId']),
  },
  created() {
    this.onRouteId()
    this.onMeta()
  },
}
</script>
