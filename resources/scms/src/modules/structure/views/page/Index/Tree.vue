<template>
  <div>

    <vue-context ref="menu">
      <template slot-scope="child" v-if="child.data">
        <li>
          <a v-if="canAction('structure.page.update')" @click.prevent="onClickContextMenuItemUpdate(child.data)">{{ $t('property') }}</a>
          <a v-if="canAction('structure.page.store')" @click.prevent="onClickContextMenuItemCreate(child.data)">{{ $t('create') }}</a>
          <a v-if="canAction('structure.page.destroy')" @click.prevent="onClickContextMenuItemDelete(child.data)">{{ $t('destroy') }}</a>
        </li>
      </template>
    </vue-context>

    <ul class="structure-treeview">
      <tree-item
        :item="treeData"
        :children="treeData.children"
        :refs="$refs"
      ></tree-item>
    </ul>

  </div>
</template>

<script>
import TreeItem from './TreeItem';
import {VueContext} from 'vue-context';
import { bus } from '@/main';
import 'vue-context/src/sass/vue-context.scss';
import './css/tree.css';

export default {
  name: 'tree',
  props: {
    treeData: Object
  },
  components: {
    TreeItem, VueContext
  },
  data () {
    return {
    }
  },
  methods: {
    onClickContextMenuItemUpdate (item) {
      bus.$emit('strcuturePageItemUpdate', item);
    },
    onClickContextMenuItemCreate (item) {
      bus.$emit('strcuturePageItemCreate', item);
    },
    onClickContextMenuItemDelete (item) {
      bus.$emit('strcuturePageItemDelete', item);
    },
  }
}
</script>
