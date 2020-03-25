<template>
  <div>
    <form ref="form" @submit.stop.prevent="submitPageForm">
      <div>
        <b-tabs content-class="mt-3">
          <b-tab :title="$t('tab.main')" active>

            <b-form-group
              :label="labels.alias"
              label-for="alias" :class="{'is-invalid': errors.alias}"
              label-cols-sm="4"
              >
              <b-form-input id="alias" v-model="model.alias" @keyup.enter="submitPageForm()"  />
              <span class="text-danger" v-if="errors.alias">{{ errors.alias[0] }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.template_id"
              label-for="template_id"
              :class="{'is-invalid': errors.template_id}"
              label-cols-sm="4"
              >
              <b-form-select
                id="template_id"
                v-model="model.template_id"
                :options="templatesList"
              ></b-form-select>
              <span class="text-danger" v-if="errors.template_id">{{ errors.template_id[0] }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.is_search"
              label-for="is_search"
              :class="{'is-invalid': errors.is_search}"
              label-cols-sm="4"
            >
              <b-form-radio-group
                id="is_search"
                v-model="model.is_search"
                :options="$data.optionsNoYes"
                buttons
                button-variant="outline-primary"
                size="sm"
              ></b-form-radio-group>
              <span class="text-danger" v-if="errors.is_search">{{ errors.is_search[0] }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.is_breadcrumbs"
              label-for="is_breadcrumbs"
              :class="{'is-invalid': errors.is_breadcrumbs}"
              label-cols-sm="4"
              >
              <b-form-radio-group
                id="is_breadcrumbs"
                v-model="model.is_breadcrumbs"
                :options="$data.optionsNoYes"
                buttons
                button-variant="outline-primary"
                size="sm"
              ></b-form-radio-group>
              <span class="text-danger" v-if="errors.is_breadcrumbs">{{ errors.is_breadcrumbs[0] }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.body_class"
              label-for="body_class" :class="{'is-invalid': errors.body_class}"
              label-cols-sm="4"
              >
              <b-form-input id="body_class" v-model="model.body_class" @keyup.enter="submitPageForm()"  />
              <span class="text-danger" v-if="errors.body_class">{{ errors.body_class[0] }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.is_menu"
              label-for="is_menu"
              :class="{'is-invalid': errors.is_menu}"
              label-cols-sm="4"
              >
              <b-form-radio-group
                id="is_menu"
                v-model="model.is_menu"
                :options="$data.optionsNoYes"
                buttons
                button-variant="outline-primary"
                size="sm"
              ></b-form-radio-group>
              <span class="text-danger" v-if="errors.is_menu">{{ errors.is_menu[0] }}</span>
            </b-form-group>

            <b-form-group
              :label="labels.is_canonical"
              label-for="is_canonical"
              :class="{'is-invalid': errors.is_canonical}"
              label-cols-sm="4"
              >
              <b-form-radio-group
                id="is_canonical"
                v-model="model.is_canonical"
                :options="$data.optionsNoYes"
                buttons
                button-variant="outline-primary"
                size="sm"
              ></b-form-radio-group>
              <span class="text-danger" v-if="errors.is_canonical">{{ errors.is_canonical[0] }}</span>
            </b-form-group>

          </b-tab>

          <!-- tabs locale -->
          <b-tab v-for="locale in getLocales()" :title="locale">

            <b-form-group
              :label="labels.seo_title"
              :label-for="locale + '-seo_title'"
              :class="{'is-invalid': getErrorLocale('seo_title', locale)}"
              label-cols-sm="4"
              >
              <b-form-input
                :id="locale + '-seo_title'"
                :name="locale + '[seo_title]'"
                v-model="model[locale].seo_title"
                @keyup.enter="submitPageForm()"  />
              <span class="text-danger"
                v-if="getErrorLocale('seo_title', locale)">
                {{ getErrorLocale('seo_title', locale) }}
              </span>
            </b-form-group>

            <b-form-group
              :label="labels.seo_h1"
              :label-for="locale + '-seo_h1'"
              :class="{'is-invalid': getErrorLocale('seo_h1', locale)}"
              label-cols-sm="4"
              >
              <b-form-input
                :id="locale + '-seo_h1'"
                :name="locale + '[seo_h1]'"
                v-model="model[locale].seo_h1"
                @keyup.enter="submitPageForm()"  />
              <span class="text-danger"
                v-if="getErrorLocale('seo_h1', locale)">
                {{ getErrorLocale('seo_h1', locale) }}
              </span>
            </b-form-group>

            <b-form-group
              :label="labels.seo_description"
              :label-for="locale + '-seo_description'"
              :class="{'is-invalid': getErrorLocale('seo_description', locale)}"
              label-cols-sm="4"
              >
              <b-form-input
                :id="locale + '-seo_description'"
                :name="locale + '[seo_description]'"
                v-model="model[locale].seo_description"
                @keyup.enter="submitPageForm()"  />
              <span class="text-danger"
                v-if="getErrorLocale('seo_description', locale)">
                {{ getErrorLocale('seo_description', locale) }}
              </span>
            </b-form-group>

            <b-form-group
              :label="labels.breacrumbs_title"
              :label-for="locale + '-breacrumbs_title'"
              :class="{'is-invalid': getErrorLocale('breacrumbs_title', locale)}"
              label-cols-sm="4"
              >
              <b-form-input
                :id="locale + '-breacrumbs_title'"
                :name="locale + '[breacrumbs_title]'"
                v-model="model[locale].breacrumbs_title"
                @keyup.enter="submitPageForm()"  />
              <span class="text-danger"
                v-if="getErrorLocale('breacrumbs_title', locale)">
                {{ getErrorLocale('breacrumbs_title', locale) }}
              </span>
            </b-form-group>

            <b-form-group
              :label="labels.head"
              :label-for="locale + '-head'"
              :class="{'is-invalid': getErrorLocale('head', locale)}"
              label-cols-sm="4"
              >
              <b-form-textarea
                :id="locale + '-head'"
                :name="locale + '[head]'"
                v-model="model[locale].head"
                @keyup.enter="submitPageForm()"  />
              <span class="text-danger"
                v-if="getErrorLocale('head', locale)">
                {{ getErrorLocale('head', locale) }}
              </span>
            </b-form-group>

          </b-tab>

          </b-tabs>
        </div>
        <b-button variant="success" class="btn-width-md" @click="submitPageForm()">
          {{ model.id ? $t('update') : $t('create') }}
        </b-button>
      </form>
  </div>
</template>

<script>

import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'

export default {
  computed: {
    ...mapState('structurePages', {
      errors: state => state.errors,
      model: state => state.pageModel,
      labels: state => state.labels.fields
    }),
    ...mapGetters('structurePages', ['templatesList'])
  },
  methods: {
    ...mapActions('structurePages', ['submitPageForm']),
  }
}
</script>
