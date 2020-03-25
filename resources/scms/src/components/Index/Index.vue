<template>
  <div>
    <div class="mb-md">
      <router-link
        v-if="canAction(canActionPath + '.store')"
        :to="linkCreate"
        class="btn btn-success btn-width-md mr-xs">{{ $t('create') }}</router-link>
      <b-button
        variant="danger"
        class="btn-width-md mr-xs"
        v-if="canAction(canActionPath + '.destroy')"
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
          <input type="checkbox" id="table-marks-all" v-model="marksAll" @change="tableDestroyMarkAll($event, tableId)" />
          <label for="table-marks-all" />
        </div>

        <div class="abc-checkbox text-center" slot="marks" slot-scope="props">
          <input type="checkbox" :id="'table-mark-' + props.row.id" :value="props.row.id" v-model="ids" />
          <label :for="'table-mark-' + props.row.id" />
        </div>

        <div slot="actions" slot-scope="props" class="table-icons">
          <router-link
            :to="url + '/' + props.row.id"
            class="table-icons__btn glyphicon glyphicon-edit"
            v-if="canAction(canActionPath + '.update') && canActionEdit(props.row)"
          />

          <div
            class="table-icons__btn glyphicon glyphicon-remove"
            v-if="canAction(canActionPath + '.destroy') && canActionDestroy(props.row)"
            @click.prevent="tableModalWarning(modal.destroy, props.row.id)"
          />

          <div
            class="table-icons__btn glyphicon glyphicon-"
            v-if="canAction(canActionPath + '.view')"
            @click.prevent="tableModalWarning(modal.destroy, props.row.id)"
          />

          <router-link
            :to="url + '/' + props.row.id + '/view'"
            class="table-icons__btn glyphicon glyphicon-eye-open"
            v-if="canAction(canActionPath + '.view')"
          />

          <template v-for="item in addtActions">
            <router-link
              :to="item.url(props.row)"
              :class="'table-icons__btn glyphicon glyphicon-' + item.icon"
              :title="item.title"
              v-if="canAction(item.permission)"
              />
          </template>
        </div>

      </v-server-table>
      <Loader v-if="isReady && isLoading"></Loader>
    </div>

    <b-modal :id="modal.destroy" body-class="bg-white" v-if="canAction(canActionPath + '.destroy')">
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
  name: 'Index',
  props: [
    'addtActions',
    'tableId',
    'url',
    'columns',
    'options',
    'modal',
    'name',
    'linkCreate',
    'canActionPath',
    'canEditable',
    'canDestrable',
  ],
  components: { Loader },
  computed: {
    ...mapState('index', {
      isReady: state => state.isReady,
      isLoading: state => state.isLoading,
      isRefresh: state => state.isRefresh,
      clearIds: state => state.clearIds,
      marksLength: state => state.marksLength,
    }),
    marksAll: {
      get() { return this.$store.state.index.marksAll },
      set(value) { this.$store.commit('index/setState', { marksAll: value }, { root: true }) }
    },
    ids: {
      get() { return this.$store.state.index.ids },
      set(value) { this.$store.commit('index/setState', { ids: value }, { root: true }) }
    },
  },
  methods: {
    ...mapMutations('index', ['setState', 'setLoading']),
    ...mapActions('index', ['onDestroy']),
    canActionEdit (row) {
      if (typeof this.canEditable !== 'undefined') {
        return this.canEditable(row);
      } else {
        return true;
      }
    },
    canActionDestroy (row) {
      if (typeof this.canDestrable !== 'undefined') {
        return this.canDestrable(row);
      } else {
        return true;
      }
    },
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
    this.setState({
      url: this.url
    });
  },
};
</script>
