<template>
  <div>

    <form @submit.prevent="onSubmit('save')">
      <b-form-group
        label-for="name"
        horizontal
        :label="meta.fields.title"
        :description="meta.description.title"
        :label-cols="2"
      >
        <b-form-input
          type="text"
          name="title"
          id="title"
          :class="{'is-invalid': errorMessage.title}"
          v-model="model.title"
        />
        <span class="text-danger" v-if="errorMessage.title">
          {{ errorMessage.title[0] }}
        </span>
      </b-form-group>

      <b-form-group
        label-for="is_active"
        horizontal
        :label="meta.fields.is_active"
        :description="meta.description.is_active"
        :label-cols="2"
      >
        <b-form-radio-group
          id="is_active"
          name="is_active"
          :options="optionsNoYes"
          v-model="model.is_active"
          buttons
          button-variant="outline-primary"
        />
        <span class="text-danger" v-if="errorMessage.is_active">
          {{ errorMessage.is_active[0] }}
        </span>
      </b-form-group>

      <b-form-group
        label-for="is_sitemap"
        horizontal
        :label="meta.fields.is_sitemap"
        :description="meta.description.is_sitemap"
        :label-cols="2"
      >
        <b-form-radio-group
          id="is_sitemap"
          name="is_sitemap"
          :options="optionsNoYes"
          v-model="model.is_sitemap"
          buttons
          button-variant="outline-primary"
        />
        <span class="text-danger" v-if="errorMessage.is_sitemap">
          {{ errorMessage.is_sitemap[0] }}
        </span>
      </b-form-group>

      <div class="row">
        <div class="col-sm-3">
          <MenuDomainTree :tree-data="tree" v-if="tree" />
        </div>
        <div class="col-sm-9">
          <MenuItemsTree v-if="treeItems.length" />
        </div>
      </div>

      <b-form-group class="form-action">
        <div class="btns-left">
          <b-button
            variant="default"
            class="btn-set"
            @click.prevent="onCancel"
          >
            {{ $t('cancel') }}
          </b-button>
        </div>
        <div class="btns-right">
          <b-button
            variant="primary"
            type="submit"
            class="btn-set"
            v-if="model.id"
          >
            {{ isFetching == 'save' ? $t('loading') : $t('save') }}
          </b-button>

          <b-button
            variant="primary"
            class="btn-set"
            @click.prevent="onSaveExit"
          >
            {{ isFetching == 'saveExit' ? $t('loading') : $t('save.exit') }}
          </b-button>
        </div>
      </b-form-group>
    </form>

    <b-modal
      v-model="modalItemForm.show"
      id="modal-menu-item-form"
      size="lg"
      hide-footer
      hide-header
      body-class="bg-white">
        <MenuFormItem />
    </b-modal>

  </div>
</template>

<script>
import router from '@/Routes';
import { mapState, mapActions, mapMutations } from 'vuex';
import InputFilePreview from '@/components/FormElements/InputFilePreview/InputFilePreview';
import { bus } from '@/main';
import MenuDomainTree from './MenuDomainTree'
import MenuItemsTree from './MenuItemsTree'
import MenuFormItem from './MenuFormItem'
import VueJsonPretty from 'vue-json-pretty'

export default {
  name: 'MenuForm',
  components: {
    MenuDomainTree,
    MenuItemsTree,
    MenuFormItem,
    InputFilePreview,
    VueJsonPretty
  },
  computed: {
    ...mapState('menuForm', {
      modalItemForm: state => state.modalItemForm,
      meta: state => state.meta.menu,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errorMessage: state => state.errorMessage,
      tree: state => state.tree,
      treeItems: state => state.treeMenuItems,
    }),
  },
  methods: {
    ...mapMutations('menuForm', [
      'setState',
      'setModel',
      'setDomainId',
    ]),
    ...mapActions('menuForm', [
      'onMeta',
      'onGetDomain',
      'onSubmit',
      'onCancel',
      'onSaveExit'
    ]),
  },
  created() {
    let id = router.currentRoute.params.id;
    let domainId = router.currentRoute.params.domainId;

    // form update
    if (id) {
      this.setModel({id});
    }

    // form create
    if (domainId) {
      this.setDomainId(domainId);
      this.onGetDomain();
    }

    this.onMeta();
  },
  mounted() {

  },
};
</script>
