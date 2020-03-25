<template>
  <li v-if="isShow">
    <div
      :class="{bold: isFolder}"
      :key="item.structure_id"
      >
      <a href="#"
        @contextmenu.prevent="refs.menu.open($event, item)"
        @click.stop.prevent="onClick"
      >{{ item.title }} ({{ item.alias }})</a>
      <span v-if="isFolder" @click="toggle" :class="{expanded: isOpen, collapsed: !isOpen}"></span>
    </div>
    <ul v-show="isOpen" v-if="isFolder" :class="{'d-block': isOpen, 'd-none': !isOpen}">
      <tree-item
        v-for="(child, index) in children"
        :key="child.id"
        :item="child"
        :children="child.children"
        :refs="refs"
      ></tree-item>
    </ul>
  </li>
</template>

<script>
import { bus } from '@/main';
import { mapActions } from 'vuex'
import routes from '@/Routes'

export default {
  name: 'tree-item',
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
    toggle: function () {
      if (this.isFolder) {
        this.isOpen = !this.isOpen
      }
    },
    onClick: function () {

      bus.$emit('tree-item-click', this.item);
    }
  },
  mounted() {
    if (typeof routes.currentRoute.params.pageId !== 'undefined' &&
        routes.currentRoute.params.pageId == this.item.id
    ) {
      bus.$emit('tree-item-click', this.item);
    }

    bus.$on('update-page-' + this.item.id, data => {
      this.item.title = data[this.$i18n.locale].seo_title;
      this.item.alias = data.alias;
    });

    bus.$on('add-child-' + this.item.id, data => {
      //data.title = data[this.$i18n.locale].seo_title
      //data.children = []
      //this.children.push(data)
      this.getTree()
    });

    bus.$on('delete-page-' + this.item.id, data => {
      //this.isShow = false;
      this.getTree()
    });
  },
  beforeDestroy: function() {
  	bus.$off('update-page-' + this.item.id);
  	bus.$off('add-child-' + this.item.id);
    bus.$off('delete-page-' + this.item.id);
  }
}
</script>
