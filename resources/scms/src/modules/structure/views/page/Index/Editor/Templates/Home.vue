<template>
  <div>
    <h1>Home</h1>
    <div class="row">
      <div class="col-sm-12">
        <place
          v-for="i in 10"
          :alias="'content' + i"
          :widget="pageBlocks['content' + i] || {}"
          :refs="refs"
        />
      </div>
    </div>
  </div>
</template>

<script>
import {VueContext} from 'vue-context';
import Place from '../Place'
import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'

export default {
  props: ['refs'],
  components: { Place },
  data () {
    return {
    }
  },
  computed: {
    ...mapState('structurePages', {
      pageBlocks: state => state.pageBlocks,
    })
  },
}
</script>
