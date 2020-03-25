<template>
  <li v-if="isShow">
    <div
      :class="{bold: isFolder}"
      :key="item.structure_id"
      >
      <a href="#"
        @click.stop.prevent="onClick"
      >{{ item.title }} ({{ item.alias }})</a>
      <span v-if="isFolder" @click="toggle" :class="{expanded: isOpen, collapsed: !isOpen}"></span>
    </div>
    <ul v-show="isOpen" v-if="isFolder" :class="{'d-block': isOpen, 'd-none': !isOpen}">
      <menu-tree-item
        v-for="(child, index) in children"
        :key="child.id"
        :item="child"
        :children="child.children"
      ></menu-tree-item>
    </ul>
  </li>
</template>

<script>
import { bus } from '@/main';
import { mapActions, mapMutations } from 'vuex'
import config from "@/config";

export default {
  name: 'MenuTreeItem',
  props: ['item', 'children', 'refs'],
  data: function () {
    return {
      isOpen: true,
      isShow: true
    }
  },
  computed: {
    isFolder: function () {
      return this.item.children && Object.keys(this.item.children).length
    }
  },
  methods: {
    ...mapActions('structurePages', ['getTree']),
    ...mapMutations('menuForm', [
      'setMenuItemsAppend',
    ]),
    toggle: function () {
      if (this.isFolder) {
        this.isOpen = !this.isOpen
      }
    },
    onClick: function () {

      let item = {
        page_id: this.item.id,
        name: this.item.title,
        is_active: 1,
        is_targer_blank: 0,
        class: '',
        style: '',
        changefreq: '',
        priority: '',
        image: '',
      }

      for (let key in config.locales) {
        item[config.locales[key]] = {
            title: this.item.title,
            link: '',
            description: '',
        }
      }
      item.children = [];

      this.setMenuItemsAppend(item)
    }
  },
  mounted() {
  }
}
</script>
