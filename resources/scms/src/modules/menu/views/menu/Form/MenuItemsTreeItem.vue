<template>
  <draggable
    v-bind="dragOptions"
    tag="div"
    class="item-container"
    :list="list"
    :value="value"
    @input="emitter"
  >
    <div class="item-group" :key="getUid(index)" v-for="(item, index) in realValue">
      <div class="item-group-content">
        <div>{{ item.name }} <img :src="imgSrc(item.image)" height="20"></div>
        <div class="actions">
          <a href="#" class="ml-3 table-icons__btn glyphicon glyphicon-edit" @click.prevent="editItem(item, getUid(index))"></a>
          <a href="#" class="table-icons__btn glyphicon glyphicon-remove" @click.prevent="removeItem(getUid(index))"></a>
        </div>
      </div>
      <MenuItemsTreeItem class="item-sub" :list="item.children" :depth="getUid(index)" />
    </div>
  </draggable>
</template>

<script>
import draggable from "vuedraggable"
import { mapState, mapActions, mapMutations } from 'vuex'

export default {
  name: "MenuItemsTreeItem",
  props: {
    depth: {
      required: false,
      default: ''
    },
    value: {
      required: false,
      type: Array,
      default: null
    },
    list: {
      required: false,
      type: Array,
      default: null
    }
  },
  components: {
    draggable
  },
  computed: {
    ...mapState('menuForm', {
      treeMenuItems: state => state.treeMenuItems
    }),
    dragOptions() {
      return {
        animation: 0,
        group: "description",
        disabled: false,
        ghostClass: "ghost"
      }
    },
    // this.value when input = v-model
    // this.list  when input != v-model
    realValue() {
      return this.value ? this.value : this.list
    }
  },
  methods: {
    ...mapMutations('menuForm', [
      'setModalItemForm',
      'setItemModel',
      'updateTreeMenuItems',
    ]),
    emitter(value) {
      this.$emit("input", value)
    },
    removeItem: function (path) {
      let mapTree = this.toMapParentsFromTree(this.treeMenuItems);
      delete mapTree[path];
      let tree = this.toTree(mapTree);
      this.updateTreeMenuItems(tree);
    },
    editItem: function (data, path) {
      data.path = path;
      this.setItemModel(data)
      this.setModalItemForm({show: true})
    },
    getUid: function (index) {
      return this.depth === '' ? index : this.depth + '_' + index
    }
  }
}
</script>

<style scoped="">
.item-group {
  margin-top: 8px;
  padding-left: 2px;
}

.item-group-content {
  border: solid 1px #ccc;
  padding: 6px;
}

.item-group-content .actions {
  float:right;
  margin-top: -15px;
}

.item-container {
  max-width: 60rem;
  margin: 0;
  min-height: 20px;
}

.item {
  padding: 1rem;
  border: solid black 1px;
  background-color: #fefefe;
}
.item-sub {
  min-height: 5px;
  margin: 0 0 0 1rem;
}

.ghost {
  border: dotted 1px #999;
  height: 40px;
  background-color: red;
  display: block;
}

.sortable-drag {
  border: dotted 1px #069;
  height: 40px;
  background-color: green;
  display: block;
}

.sortable-chosen {
  background-color: #ccc;
  color: #000;
}
</style>
