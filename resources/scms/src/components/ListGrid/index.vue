<template>
  <div>
    <div class="text-left">
      <div class="spinner-border text-primary" role="status" v-if="isLoading">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div class="text-right"
         v-if="canActions([permission + '.destroy', permission + '.stoare'])"
    >
      <label class="pr-2">
        <input type="checkbox"
               v-model="selectAll"
               :disabled="!items.length"
               v-if="canAction(permission + '.destroy')"
      />Selected all</label>
      <button type="button"
              class="btn btn-success mb-2"
              @click="addItem()"
              v-if="canAction(permission + '.store')"
      >+</button>
      <button type="button"
              class="btn btn-danger ml-2 mb-2"
              :disabled="!selected.length"
              @click="removeItems()"
              v-if="canAction(permission + '.destroy')"
      >x</button>
    </div>

    <b-modal
      v-if="canAction(permission + '.destroy')"
      v-model="modalDeleteShow"
      id="modal-delete"
      size="md"
      body-class="bg-white">
      <p v-text="$t('modal.message.delete')" />
      <template v-slot:modal-footer>
        <b-button variant="default" class="btn-width-md" @click="$bvModal.hide('modal-delete')">
          {{ $t('cancel') }}
        </b-button>
        <b-button variant="danger" class="btn-width-md ml-2" @click="onRemoveItems()">
          {{ $t('confirm') }}
        </b-button>
      </template>
    </b-modal>

    <b-modal
      v-model="modalFormShow"
      id="modal-page-form"
      size="lg"
      hide-footer
      :title="modaFormTitle"
      body-class="bg-white">

      <form @submit.stop.prevent="onSubmitForm" v-if="modalFormShow">

        <b-tabs content-class="mt-3">
          <b-tab :title="$t('tab.main')"
                 :title-link-class="hasErrorsInTabMain() ? 'error':''"
          >
            <b-form-group
              v-for="(field, index) in meta.model.fields"
              :label="meta.labels.fields[index]"
              :label-for="index" :class="{'is-invalid': errors[index]}"
              :label-class="typeof field.required !== 'undefined' && field.required ? 'required':''"
              label-cols-sm="4"
              >

              <b-form-input
                v-if="field.type === 'input'"
                v-model="model[index]"
              />

              <image-base64
                v-if="field.type === 'image'"
                v-model="model[index]"
              />

              <b-form-radio-group
                v-if="field.type === 'checkbox'"
                :name="id + '-' + index"
                v-model="model[index]"
                :options="optionsNoYes"
                buttons
                button-variant="outline-primary"
              />

              <b-form-select
                v-if="field.type === 'select'"
                :name="id + '-' + index"
                v-model="model[index]"
                :options="field.options"
              />

              <span class="text-danger"
                    v-if="errors[index]">
                  {{ errors[index][0] }}
              </span>

            </b-form-group>
          </b-tab>

          <b-tab v-if="hasTranslatable"
                 v-for="locale in getLocales()" :title="locale"
                 :title-link-class="hasErrorsInTabLocale(locale) ? 'error':''"
          >

             <b-form-group
               v-for="(field, index) in meta.model.translatable"
               :label="meta.labels.fields[index]"
               :label-for="index + '-' + locale"
               :class="{'is-invalid': getErrorLocale(index, locale)}"
               :label-class="typeof field.required !== 'undefined' && field.required ? 'required':''"
               label-cols-sm="4"
               >

               <b-form-input
                 v-if="field.type === 'input'"
                 :id="index + '-' + locale"
                 v-model="model[locale][index]"
               />

               <b-form-textarea
                 v-if="field.type === 'textarea'"
                 :id="index + '-' + locale"
                 v-model="model[locale][index]"
               />

               <editor
                 v-if="field.type === 'ckeditor'"
                 :id="index + '-' + locale"
                 v-model="model[locale][index]"
               />

               <span class="text-danger"
                     v-if="getErrorLocale(index, locale)">
                  {{ getErrorLocale(index, locale) }}
               </span>

             </b-form-group>
          </b-tab>

        </b-tabs>

        <b-form-group>
          <b-button variant="success" class="btn-width-md" @click="onSubmitForm">
            {{ $t('save') }}
          </b-button>
        </b-form-group>
    </form>
    </b-modal>
    <div class="grid-list-items">
      <draggable
        v-bind="dragOptions"
        tag="div"
        :list="items"
        draggable=".item"
        @end="moveItem"
        class="row"
      >
          <div class="col-md-2 mb-4 item" v-for="(item, index) in items">
            <div class="card grid-list-item"
                  :key="index"
             >
              <div class="card-body"
                   :class="{inactive: hasInactiveClass(item)}"
              >
                <img
                  v-if="imageAttr && typeof item[imageAttr] !== 'undefined'"
                  class="card-img-top"
                  :src="domainPath + item[imageAttr]"
                />
                <h5 class="card-title">{{ item[titleAttr] }}</h5>
                <p class="card-text" v-if="descriptionAttr && typeof item[descriptionAttr] !== 'undefined'">
                    {{ item[descriptionAttr] }}
                </p>
              </div>
              <div class="card-footer"
                   v-if="canActions([permission + '.destroy', permission + '.update'])"
                >
                <div class="float-left">
                  <input type="checkbox"
                         :value="item.id"
                         v-model="selected"
                         v-if="canAction(permission + '.destroy')"
                  />
                </div>
                <div class="float-right">
                  <a href="#"
                     v-if="canAction(permission + '.update')"
                     @click.prevent="editItem(item.id)"
                     class="table-icons__btn glyphicon glyphicon-edit">
                  </a>
                  <a href="#"
                     v-if="canAction(permission + '.destroy')"
                     @click.prevent="removeItem(item.id)"
                     class="table-icons__btn glyphicon glyphicon-remove">
                  </a>
                </div>
              </div>
            </div>
          </div>
      </draggable>
    </div>

  </div>
</template>

<script>

import config from "@/config"
import draggable from "vuedraggable"
import ImageBase64 from '@/components/FormElements/InputFilePreview/ImageFileBase64'

export default {
  name: 'ListGrid',
  components: { draggable, ImageBase64 },
  props: {
    id: {
      type: String,
      required: true
    },

    url: {
      type: String,
      required: true
    },

    permission: {
      type: String,
      required: true
    },

    titleAttr: {
      type: String,
      default: 'title',
    },

    imageAttr: {
      type: String,
      default: false,
    },

    descriptionAttr: {
      type: String,
      default: false,
    },

    inactiveAttr: {
      type: String,
      default: false,
    }
  },
  data: function () {
    return {
      model: {},
      meta: {},
      errors: {},
      items: [],
      selected: [],
      itemsToRemove: [],
      dragOptions: {
          animation: 500,
          group: "description",
          disabled: false,
          ghostClass: "ghost"
      },
      modalFormShow: false,
      modalDeleteShow: false,
      isLoading: false,
    }
  },
  computed: {
    selectAll: {
        get: function () {
            return this.items.length ? this.selected.length == this.items.length : false
        },
        set: function (value) {
            var selected = []
            if (value) {
                this.items.forEach(function (item) {
                    selected.push(item.id)
                })
            }
            this.selected = selected
        }
    },

    domainPath: function() {
        return config.url
    },

    getDefaultModel: function() {
      let model = {id: ''}

      for (let key in this.meta.model.fields) {
        let conf = this.meta.model.fields[key]
        model[key] = typeof conf.default !== 'undefined' ? conf.default : ''
      }
      //translatable
      if (typeof this.meta.model.translatable !== 'undefined') {
        for (let keyLocale in config.locales) {
          model[config.locales[keyLocale]] = {}
          for (let keyAttr in this.meta.model.translatable) {
            model[config.locales[keyLocale]][keyAttr] = ''
          }
        }
      }

      return model
    },

    modaFormTitle: function() {
      return (typeof this.meta.labels !== 'undefined' && typeof this.meta.labels.title !== 'undefined')
         ? (this.model.id != '' ? this.meta.labels.title.updating : this.meta.labels.title.creating)
         : ''
    },

    hasTranslatable: function() {
      return typeof this.meta.model !== 'undefined' &&
             typeof this.meta.model.translatable !== 'undefined'
    }
  },
  methods: {

    onFetchMeta: function () {
      axios({
        url: this.url + '/meta'
      })
      .then(response => {
        this.meta = response.data
        this.model = this.getDefaultModel
      })
      .catch(error => {
        if (error.response) {
          alert(error.response)
        }
      })
    },

    onSubmitForm: function () {
       let url = this.model.id != '' ? this.url + '/' + this.model.id : this.url
       let method = this.model.id != '' ? 'PUT' : 'POST'
       let data = this.model

       axios({url, method, data})
       .then(response => {
         this.modalFormShow = false
         this.model = this.getDefaultModel
         this.onFetchItems()

         if (model.id !== '') {
           this.onFetchItems()
           /* todo
           for (let key in this.items) {
             if (model.id == this.items[key].id) {
               this.items[key] = response.data.data
             }
           }
           */
         } else {
           //this.items.push(response.data.data)
         }
       })
       .catch(error => {
         if (typeof error.response !== 'undefined' && error.response.status === 422) {
           this.errors =  error.response.data.errors
         }
       })
     },
     onFetchItems: function () {
       this.isLoading = true
       axios({
         url: this.url
       })
       .then(response => {
         this.items = response.data.data
         this.isLoading = false
       })
       .catch(error => {
         this.responseError(error.response)
       })
     },

     onFetchItem: function () {
       this.Loading = true
       axios({
         url: this.url + '/' + this.model.id
       })
       .then(response => {
         this.model = response.data.data
         this.modalFormShow = true
         this.Loading = false
       })
       .catch(error => {
         this.responseError(error.response)
       })
     },

     onSortable: function () {
       this.isLoading = true
       let ids = []
       for (let key in this.items) {
         ids.push(this.items[key].id)
       }

       axios({
         url: this.url + '/sortable',
         method: 'PUT',
         data: {ids}
       })
       .then(response => {
         this.isLoading = false
       })
       .catch(error => {
         this.responseError(error.response)
       })
     },

     onRemoveItems: function () {
       let ids = this.itemsToRemove
       axios({
         url: this.url + '/bulk-destroy',
         method: 'DELETE',
         data: {ids}
       })
       .then(response => {
         this.modalDeleteShow = false
         this.onFetchItems()
       })
       .catch(error => {
         this.responseError(error.response)
         this.modalDeleteShow = false
       })
     },

     moveItem: function (event) {
      this.onSortable()
     },

     responseError: function(error) {
       this.Loading = false
     },

     removeItems: function () {
       this.modalDeleteShow = true
       this.itemsToRemove = this.selected
     },

     removeItem: function (id) {
      this.modalDeleteShow = true
      this.itemsToRemove = []
      this.itemsToRemove.push(id)
    },

    addItem: function () {
      this.model = this.getDefaultModel
      this.model.id = ''
      this.modalFormShow = true
      this.errors = {}
    },

    editItem: function (id) {
      this.errors = {}
      this.model.id = id
      this.onFetchItem()
    },

    // styled methods
    hasInactiveClass: function (item) {
      let value = ''
      if (this.inactiveAttr && typeof item[this.inactiveAttr] !== 'undefined' && !item[this.inactiveAttr]) {
        value = 'inactive'
      }
      return value
    }
  },
  mounted() {
    this.onFetchMeta()
    this.onFetchItems()
  }
}
</script>

<style scoped>
.grid-list-items {

}
.grid-list-item {
  width: 13rem;
}
.card-text {
    white-space: nowrap; /* Запрещаем перенос строк */
    overflow: hidden; /* Обрезаем все, что не помещается в область */
    text-overflow: ellipsis; /* Добавляем многоточие */
}
.card-title {
    white-space: nowrap; /* Запрещаем перенос строк */
    overflow: hidden; /* Обрезаем все, что не помещается в область */
    text-overflow: ellipsis; /* Добавляем многоточие */
}

.inactive {
  opacity: 0.5;
}
</style>
