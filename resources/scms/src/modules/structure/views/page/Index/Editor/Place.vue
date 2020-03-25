<template>
  <div
    class="structure-page-editor-place"
    @click="onClick(alias)"
    @contextmenu.prevent="refs.place_menu.open($event, alias)"
    >
    {{ alias }}
    <div v-if="typeof widget.widget_id !== 'undefined'" class="widget">{{ widget.widget_id }}/{{ widget.action }}</div>
  </div>
</template>

<script>
import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'

export default {
  props: ['alias', 'refs', 'widget'],
  methods: {
    ...mapMutations('structurePages', [
      'setBlockModel'
    ]),
    ...mapActions('structurePages', [
      'onGetBlock',
    ]),
    onClick(alias) {
      this.setBlockModel({alias});
      this.onGetBlock();
    }
  }
}
</script>
