import Vue from 'vue';
import Vuex from 'vuex';

import layout from '@/components/Layout/store';
import alert from '@/components/Alert/store';
import index from '@/components/Index/store';

@foreach ($stores as $k => $v)
import {{ $k }} from '{{ $v }}';
@endforeach

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    layout,
    alert,
    index,
@foreach ($stores as $k => $v)
    {{ $k }},
@endforeach
  },
});
