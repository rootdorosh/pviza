<template>
  <div>

    <ul class="structure-treeview">
      <menu-domain-tree-item
        :item="treeData"
        :children="treeData.children"
      ></menu-domain-tree-item>
    </ul>

  </div>
</template>

<script>
import MenuDomainTreeItem from './MenuDomainTreeItem';
import { bus } from '@/main';
import '@/modules/structure/views/page/Index/css/tree.css';

export default {
  name: 'MenuDomainTree',
  props: {
    treeData: Object
  },
  components: {
    MenuDomainTreeItem
  },
  data () {
    return {
    }
  },
  methods: {
    onClickContextMenuItemUpdate (item) {

    },
  }
}
</script>
