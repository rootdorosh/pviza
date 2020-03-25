<template>
  <div>

    <form @submit.stop.prevent="onSubmitForm()">
      <div>
        <b-tabs content-class="mt-3">
          <b-tab :title="$t('tab.main')" active>

            <b-form-group
              :label="labels.name"
              label-for="name" :class="{'is-invalid': errors.name}"
              label-cols-sm="4"
              >
              <b-form-input id="name" v-model="model.name" @keyup.enter="onSubmitForm()"  />
              <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.is_active"
              label-for="is_search"
              :class="{'is-invalid': errors.is_active}"
              label-cols-sm="4"
            >
              <b-form-radio-group
                id="is_search"
                v-model="model.is_active"
                :options="$data.optionsNoYes"
                buttons
                button-variant="outline-primary"
                size="sm"
              ></b-form-radio-group>
              <span class="text-danger" v-if="errors.is_active">{{ errors.is_active[0] }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.is_targer_blank"
              label-for="is_targer_blank"
              :class="{'is-invalid': errors.is_targer_blank}"
              label-cols-sm="4"
              >
              <b-form-radio-group
                id="is_targer_blank"
                v-model="model.is_targer_blank"
                :options="$data.optionsNoYes"
                buttons
                button-variant="outline-primary"
                size="sm"
              ></b-form-radio-group>
              <span class="text-danger" v-if="errors.is_targer_blank">{{ errors.is_targer_blank[0] }}</span>
            </b-form-group>

            <b-form-group
              label-for="image"
              horizontal
              :label="labels.image"
              label-cols-sm="4"
            >
              <input-file-base64
                name="image"
                :value="model.image"
              />
              <span class="text-danger" v-if="errors.image">
                {{ errors.image[0] }}
              </span>
            </b-form-group>

            <b-form-group
              :label="labels.style"
              label-for="style" :class="{'is-invalid': errors.style}"
              label-cols-sm="4"
              >
              <b-form-input id="style" v-model="model.style" @keyup.enter="onSubmitForm()"  />
              <span class="text-danger" v-if="errors.style">{{ errors.style[0] }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.class"
              label-for="class" :class="{'is-invalid': errors.class}"
              label-cols-sm="4"
              >
              <b-form-input id="class" v-model="model.class" @keyup.enter="onSubmitForm()"  />
              <span class="text-danger" v-if="errors.class">{{ errors.class[0] }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.changefreq"
              label-for="changefreq"
              :class="{'is-invalid': errors.changefreq}"
              label-cols-sm="4"
              v-if="menuModel.is_active"
              >
              <b-form-select
                id="changefreq"
                v-model="model.changefreq"
                :options="changefreqsList"
              ></b-form-select>
              <span class="text-danger" v-if="errors.changefreq">{{ errors.changefreq[0] }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.priority"
              label-for="priority"
              :class="{'is-invalid': errors.priority}"
              label-cols-sm="4"
              v-if="menuModel.is_active"
              >
              <b-form-select
                id="priority"
                v-model="model.priority"
                :options="prioritiesList"
              ></b-form-select>
              <span class="text-danger" v-if="errors.priority">{{ errors.priority[0] }}</span>
            </b-form-group>

          </b-tab>

          <!-- tabs locale -->
          <b-tab v-for="locale in getLocales()" :title="locale">

            <b-form-group
              :label="labels.title"
              :label-for="locale + '-title'"
              :class="{'is-invalid': getErrorLocale('title', locale)}"
              label-cols-sm="4"
              >
              <b-form-input
                :id="locale + '-title'"
                :name="locale + '[title]'"
                v-model="model[locale].title"
                @keyup.enter="onSubmitForm()"  />
              <span class="text-danger"
                v-if="getErrorLocale('title', locale)">
                {{ getErrorLocale('title', locale) }}
              </span>
            </b-form-group>

            <b-form-group
              :label="labels.link"
              :label-for="locale + '-link'"
              :class="{'is-invalid': getErrorLocale('link', locale)}"
              label-cols-sm="4"
              >
              <b-form-input
                :id="locale + '-link'"
                :name="locale + '[link]'"
                v-model="model[locale].link"
                @keyup.enter="onSubmitForm()"  />
              <span class="text-danger" v-if="getErrorLocale('link', locale)">{{ getErrorLocale('link', locale) }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.description"
              :label-for="locale + '-description'"
              :class="{'is-invalid': getErrorLocale('description', locale)}"
              label-cols-sm="4"
              >
              <b-form-textarea
                :id="locale + '-description'"
                :name="locale + '[description]'"
                v-model="model[locale].description"
                @keyup.enter="onSubmitForm()"  />
              <span class="text-danger" v-if="getErrorLocale('description', locale)">{{ getErrorLocale('description', locale) }}</span>
            </b-form-group>

          </b-tab>

          </b-tabs>
        </div>
        <b-button variant="success" class="btn-width-md" @click="onSubmitForm()">
          {{ model.id ? $t('update') : $t('create') }}
        </b-button>
      </form>
  </div>
</template>

<script>

import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'
import InputFileBase64 from '@/components/FormElements/InputFilePreview/InputFileBase64'
import { bus } from '@/main'

export default {
  name: 'MenuFormItem',
  components: { InputFileBase64 },
  computed: {
    ...mapState('menuForm', {
      model: state => state.itemModel,
      menuModel: state => state.model,
      labels: state => state.meta.item.fields,
      treeMenuItems: state => state.treeMenuItems,
      errors: state => state.errorMessageItem,
    }),
    ...mapGetters('menuForm', [
      'changefreqsList',
      'prioritiesList',
    ])
  },

  methods: {
    ...mapMutations('menuForm', [
      'updateTreeMenuItems',
      'setModalItemForm',
      'setErrorMessageItem',
    ]),
    onSubmitForm: function () {
      let errors = {};
      if (this.model.name === '') {
        errors.name = [this.$t('validation.required')];
      }

      if (Object.keys(errors).length) {
        this.setErrorMessageItem(errors);
        return false;
      }

      let mapTree = this.toMapParentsFromTree(this.treeMenuItems)

      for (let key in this.model) {
        mapTree[this.model.path][key] = this.model[key]
      }
      let tree = this.toTree(mapTree)
      this.updateTreeMenuItems(tree)
      this.setModalItemForm({show: false})
    }
  },
  mounted() {
    bus.$on('file-change-image', (data, isDelete) => {
      this.model.image = data.content;
      this.model.image_name = data.name;
    })
  },
  beforeDestroy: function() {
  	bus.$off('file-change-image')
  }

}
</script>
