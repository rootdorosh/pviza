<template>
  <div class="justify-content-between row">
    <MenuItemsTreeItem class="col-12" v-model="treeMenuItems" />
    <vue-json-pretty v-if="0" class="col-6" :data="treeMenuItems"></vue-json-pretty>
  </div>
</template>

<script>
import MenuItemsTreeItem from "./MenuItemsTreeItem.vue";
import VueJsonPretty from 'vue-json-pretty'
import { ArrayHelper }  from '@/mixins/ArrayHelper';
export default {

  name: "MenuItemsTree",
  display: "Nested (v-model & vuex)",
  order: 16,
  components: {
    MenuItemsTreeItem,
    VueJsonPretty
  },
  computed: {
    treeMenuItems: {
      get() {
        return this.$store.state.menuForm.treeMenuItems;
      },
      set(value) {
        this.$store.dispatch("menuForm/updateTreeMenuItems", value);
      }
    }
  },
};
</script>
