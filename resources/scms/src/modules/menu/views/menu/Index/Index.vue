<template>
  <div>
    <h2 class="page-title">{{ meta.title.index }}</h2>
    <main-content>
      <div class="mb-md" v-if="canAction('menu.menu.store')">
        <b-button
          variant="danger"
          class="btn-width-md mr-xs"
          v-if="canAction('menu.menu.destroy')"
          :disabled="!ids.length"
          @click.prevent="tableModalWarning(modal.destroy, ids, false)"
        >
          {{ isLoading == 'destroy' ? $t('loading') : $t('destroy') }}
        </b-button>
      </div>
      <div class="table-wrap">
        <v-server-table
          :ref="tableId"
          :url="url"
          :columns="columns"
          :options="options"
          @loading="tableLoading"
          @loaded="tableLoaded"
        >
          <div slot="filter__marks" class="abc-checkbox text-center">
            <input
              type="checkbox"
              id="table-marks-all"
              v-model="marksAll"
              @change="tableDestroyMarkAll($event, tableId)"
            />
            <label for="table-marks-all" />
          </div>

          <div class="abc-checkbox text-center" slot="marks" slot-scope="props">
            <input
              type="checkbox"
              :id="'table-mark-' + props.row.id"
              :value="props.row.id"
              v-model="ids"
            />
            <label :for="'table-mark-' + props.row.id" />
          </div>

          <div slot="is_active" slot-scope="props">
            <b-badge class="badge-row" variant="success" v-if="props.row.is_active">{{ $t('yes') }}</b-badge>
            <b-badge class="badge-row" variant="secondary" v-else>{{ $t('no') }}</b-badge>
          </div>

          <div slot="is_sitemap" slot-scope="props">
            <b-badge class="badge-row" variant="success" v-if="props.row.is_sitemap">{{ $t('yes') }}</b-badge>
            <b-badge class="badge-row" variant="secondary" v-else>{{ $t('no') }}</b-badge>
          </div>

          <div slot="actions" slot-scope="props" class="table-icons">
            <router-link
              :to="'/menu/menus/' + props.row.id"
              class="table-icons__btn glyphicon glyphicon-edit"
              v-if="canAction('menu.menu.update')"
            />
            <div
              class="table-icons__btn glyphicon glyphicon-remove"
              v-if="canAction('menu.menu.destroy')"
              @click.prevent="tableModalWarning(modal.destroy, props.row.id)"
            />
          </div>
        </v-server-table>
        <Loader v-if="isReady && isLoading"></Loader>
      </div>
    </main-content>
    <b-modal :id="modal.destroy" body-class="bg-white" v-if="canAction('menu.menu.destroy')">
      <template v-slot:default>
        {{ $t('modal.message.delete') }}
      </template>
      <template v-slot:modal-footer>
        <b-button variant="default" class="btn-width-md" @click="modalHide(modal.destroy)">
          {{ $t('cancel') }}
        </b-button>
        <b-button variant="danger" class="btn-width-md" @click="tableModalDestroy(modal.destroy)">
          {{ $t('confirm') }}
        </b-button>
      </template>
    </b-modal>
  </div>
</template>

<script>
import Loader from '@/components/Loader/Loader';
import { mapState, mapActions, mapMutations } from 'vuex';

export default {
  name: 'Menus',
  components: { Loader },
  computed: {
    ...mapState('menus', {
      url: state => state.url,
      modal: state => state.modal,
      meta: state => state.meta,
      columns: state => state.columns,
      options: state => state.options,
      isReady: state => state.isReady,
      isLoading: state => state.isLoading,
      isRefresh: state => state.isRefresh,
      tableId: state => state.tableId,
      clearIds: state => state.clearIds,
      marksLength: state => state.marksLength,
    }),
    marksAll: {
      get() {
        return this.$store.state.menus.marksAll;
      },
      set(value) {
        this.$store.commit('menus/setState', {
          'name': 'marksAll',
          'data': value
        });
      }
    },
    ids: {
      get() {
        return this.$store.state.menus.ids;
      },
      set(value) {
        this.$store.commit('menus/setState', {
          'name': 'ids',
          'data': value
        });
      }
    },
  },
  methods: {
    ...mapMutations('menus', ['setState', 'setInitFilters', 'setLoading']),
    ...mapActions('menus', ['onMeta', 'onDestroy']),
  },
  watch: {
    isRefresh() {
      this.tableRefresh(this.tableId);
    },
    clearIds() {
      this.tableClearMarks();
    },
    ids() {
      this.tableIdsRefresh();
    },
  },
  created() {
    this.onMeta();
    this.tableInit();
  },
  mounted() {
    this.tableModalWatch();
  },
};
</script>
