<template>
  <div>

    <h2 class="page-title">{{ labels.title.index }}</h2>

    <div class="row">
      <div class="col-sm-4">
        <Tree :tree-data="tree" v-if="tree" />
      </div>
      <div class="col-sm-8">
        <Editor />
      </div>
    </div>

    <b-modal
      v-if="canActions(['structure.page.update', 'structure.page.store'])"
      v-model="modalForm.show"
      id="modal-page-form"
      size="lg"
      hide-footer
      :title="modalForm.title"
      body-class="bg-white">
        <PageForm />
    </b-modal>

    <b-modal
      v-if="canAction('structure.page.destroy')"
      v-model="modalDelete.show"
      id="modal-page-delete"
      size="md"
      body-class="bg-white">
      <p v-text="$t('modal.message.delete')" />
      <template v-slot:modal-footer>
        <b-button variant="default" class="btn-width-md" @click="$bvModal.hide('modal-page-delete')">
          {{ $t('cancel') }}
        </b-button>
        <b-button variant="danger" class="btn-width-md ml-2" @click="onDestroyPage()">
          {{ $t('confirm') }}
        </b-button>
      </template>
    </b-modal>

  </div>
</template>

<script>
import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'
import { bus } from '@/main'
import Loader from '@/components/Loader/Loader'
import Alert from '@/components/Alert/Alert'
import routes from '@/Routes'
import Tree from './Tree'
import PageForm from './Form'
import Editor from './Editor/Index'

export default {
  name: 'StructurePages',
  components: { Loader, Alert, Tree, PageForm, Editor},
  computed: {
    ...mapState('structurePages', {
      pageModel: state => state.pageModel,
      labels: state => state.labels,
      tree: state => state.tree,
      isReady: state => state.isReady,
      isLoading: state => state.isLoading,
      isRefresh: state => state.isRefresh,
      modalForm: state => state.modalForm,
      modalDelete: state => state.modalDelete,
      modalBlockWidgetInsert: state => state.modalBlockWidgetInsert,
    })
  },
  methods: {
    ...mapMutations('structurePages', [
      'setCurrentPage',
      'setAlert',
      'setDomainId',
      'resetPageModel',
      'setPageModel',
      'setModalForm',
      'setModalDelete',
      'setCurrentPage',
    ]),
    ...mapActions('structurePages', [
      'getMeta',
      'onLoading',
      'onLoaded',
      'onDestroyPage',
      'getTree',
      'getPage'
    ])
  },
  created() {
    this.setDomainId(routes.currentRoute.params.domainId);
    this.getMeta();

    bus.$on('strcuturePageItemUpdate', data => {
      this.getPage(data.id);
    });

    bus.$on('update-page', data => {
      this.getPage(data.id);
    });

    bus.$on('strcuturePageItemCreate', data => {
      this.resetPageModel({});
      this.setPageModel({
        parent_id: data.id,
        template_id: '1',
        is_search: '1',
        is_menu: 1,
        is_breadcrumbs: 1,
        is_canonical: 0
      });

      this.setModalForm({
        show: true,
        title: this.labels.title.creating,
      });
    });

    bus.$on('strcuturePageItemDelete', data => {
      this.setCurrentPage(data);
      this.setModalDelete({
        show: true
      });
    });
  },
  beforeDestroy: function() {
  	bus.$off('strcuturePageItemUpdate');
  	bus.$off('strcuturePageItemCreate');
  	bus.$off('strcuturePageItemDelete');
  }
};
</script>

<style>
  @import '~vue-context/dist/css/vue-context.css';
</style>
