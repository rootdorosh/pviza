<template>
  <div>
    <vue-context ref="place_menu">
      <template slot-scope="child" v-if="child.data">
        <li>
          <a v-if="canAction('structure.block.insert')" @click.prevent="onClickContextMenuPlaceWidget(child.data)">{{ $t('widget') }}</a>
          <a v-if="canAction('structure.block.destroy')" @click.prevent="onClickContextMenuPlaceClear(child.data)">{{ $t('clear') }}</a>
        </li>
      </template>
    </vue-context>

    <TemplateHome v-if="editorTemplateName=='home'" :refs="$refs" />
    <TemplateLeftSide v-if="editorTemplateName=='left'" :refs="$refs" />
    <TemplateRightSide v-if="editorTemplateName=='right'" :refs="$refs" />

    <b-modal
      v-if="canAction('structure.block.insert')"
      v-model="modalBlockWidgetInsert.show"
      id="modal-page-form"
      size="lg"
      hide-footer
      :title="$t('widgets')"
      body-class="bg-white">
        <div class="row">
          <div class="col-sm-4">
            <div class="widgets-list">
                <ul>
                    <li :class="{active: widgetModel.id === widget.id}" v-for="(widget, index) in widgets">
                      <a class="wdgt" @click="selectWidget(widget)">{{ widget.name }}</a>
                    </li>
                </ul>
            </div>
          </div>
          <div class="col-sm-8">
            <form v-if="typeof widgetModel.id !== 'undefined'" ref="form-widget" @submit.stop.prevent="onSubmitWidgetForm">
                <b-form-group
                  v-for="(field, index) in widgetModel.config"
                  :label="field.label"
                  :label-for="field.name" :class="{'is-invalid': errors[field.name]}"
                  label-cols-sm="4"
                  >

                  <b-form-select
                    v-if="field.type === 'select'"
                    :id="field.name"
                    v-model="widgetModel.fields[field.name]"
                    :options="field.options"
                  ></b-form-select>

                  <span class="text-danger" v-if="errors[field.name]">{{ errors[field.name][0] }}</span>
                </b-form-group>

                <b-form-group>
                  <b-button variant="success" class="btn-width-md" @click="onSubmitWidgetForm">
                    {{ $t('save') }}
                  </b-button>
                </b-form-group>

            </form>
          </div>
        </div>
    </b-modal>

    <b-modal
      v-if="canAction('structure.block.destroy')"
      v-model="modalBlockDestroy.show"
      id="modal-block-destroy"
      size="md"
      body-class="bg-white">
      <p v-text="$t('modal.message.delete')" />
      <template v-slot:modal-footer>
        <b-button variant="default" class="btn-width-md" @click="$bvModal.hide('modal-block-destroy')">
          {{ $t('cancel') }}
        </b-button>
        <b-button variant="danger" class="btn-width-md ml-2" @click="onDestroyBlock()">
          {{ $t('confirm') }}
        </b-button>
      </template>
    </b-modal>

  </div>
</template>

<script>
import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'
import { bus } from '@/main';
import { VueContext } from 'vue-context';
import TemplateHome from './Templates/Home'
import TemplateLeftSide from './Templates/LeftSide'
import TemplateRightSide from './Templates/RightSide'
//import EditorTemplateRightSide from './Templates/RightSide'
import 'vue-context/src/sass/vue-context.scss';
import router from '@/Routes';

export default {
  components: { VueContext, TemplateHome, TemplateLeftSide, TemplateRightSide },
  data () {
    return {
    }
  },
  computed: {
    ...mapState('structurePages', {
      modalBlockDestroy: state => state.modalBlockDestroy,
      modalBlockWidgetInsert: state => state.modalBlockWidgetInsert,
      widgets: state => state.widgets,
      widgetModel: state => state.widgetModel,
      errors: state => state.widgetErrors,
      domainId: state => state.domainId,
    }),
    ...mapGetters('structurePages', [
      'editorTemplateName',
    ])
  },
  methods: {
    ...mapMutations('structurePages', [
      'setBlockModel',
      'setModalBlockDestroy',
      'setModalBlockWidgetInsert',
      'setWidgetModel',
      'setWidgetErrors',
    ]),
    ...mapActions('structurePages', [
      'onGetPageBlocks',
      'onGetWidgetsMeta',
      'onGetBlock',
      'onSubmitWidgetForm',
      'onDestroyBlock',
    ]),
    onClickContextMenuPlaceWidget (alias) {
      this.setBlockModel({alias});
      this.onGetBlock();
    },
    onClickContextMenuPlaceClear (alias) {
      this.setBlockModel({alias});
      this.setModalBlockDestroy({show: true});
    },
    selectWidget (widget) {
      this.setWidgetErrors({});
      this.setWidgetModel(widget);
    }
  },
  mounted() {
    this.onGetWidgetsMeta();

    bus.$on('tree-item-click', data => {
      this.setBlockModel({
        page_id: data.id,
        template_id: data.template_id
      });
      this.onGetPageBlocks();
      router.push('/structure/domains/' + this.domainId + '/pages/' + data.id);
    });

  },
  beforeDestroy: function() {
  	bus.$off('tree-item-click');
  }
}
</script>


<style>

.widgets-list {
	border-right:1px;
	margin:0;
	padding:0;
	display:block;
}
.widgets-list ul {
  padding-left: 0;
}

.widgets-list ul li {
	overflow:hidden;
	height:32px;
	line-height:34px;
	padding:0;
	margin:0;
	background:#f4f4f4;
	border-bottom:#ddd 1px solid;
	border-right:#ddd 1px solid;
}

.widgets-list ul li.active {
  border-left: 3px solid #666;
}

.widgets-list ul li:first-child {
	-moz-border-radius:4px 0 0 0;
	-webkit-border-radius:4px 0 0 0;
	border-radius:4px 0 0 0;
}
.widgets-list ul li:last-child {
	border-bottom:0;
	-moz-border-radius:0 0 0 4px;
	-webkit-border-radius:0 0 0 4px;
	border-radius:0 0 0 4px;
}
.widgets-list ul li.active {
	background:#eee;
	border-right:transparent 1px solid;
}
.widgets-list ul li a {
	display:block;
	padding:0 10px;
	cursor:pointer;
}
.widgets-list ul li.active a {
	cursor:default;
}
.widgets-list ul li a:hover {
	text-decoration:none;
}
.widget-params {
	background:#eee;
	border:#ddd 1px solid;
	margin-left:-1px;
	-moz-border-radius:0 4px 4px 0;
	-webkit-border-radius:0 4px 4px 0;
	border-radius:0 4px 4px 0;
}
.widget-params > div {
	margin:20px;
}

.structure-page-editor-place {
	border:#ccc 1px dotted;
	margin:-1px;
	min-height:50px;
	position:relative;
  padding-top: 3px;
}
.structure-page-editor-place:hover {
	border-style:dashed;
	border-color: #666;
}
.structure-page-editor-place .widget {
	position:absolute;
	right:0;
	top:0;
	z-index: 1;
	cursor:default;
	box-shadow:0px 0px 1px rgba(0, 0, 0, 0.5);
	color:#555;
	text-shadow:1px 1px 0 #fff;
	font-size:12px;
	letter-spacing:1px;
	padding:7px 14px 6px;
	background:-moz-linear-gradient(top,  rgba(255,255,255,0.75) 0%, rgba(214,214,214,0.75) 100%);
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0.75)), color-stop(100%,rgba(214,214,214,0.75)));
	background:-webkit-linear-gradient(top,  rgba(255,255,255,0.75) 0%,rgba(214,214,214,0.75) 100%);
	background:-o-linear-gradient(top,  rgba(255,255,255,0.75) 0%,rgba(214,214,214,0.75) 100%);
	background:-ms-linear-gradient(top,  rgba(255,255,255,0.75) 0%,rgba(214,214,214,0.75) 100%);
	background:linear-gradient(to bottom,  rgba(255,255,255,0.75) 0%,rgba(214,214,214,0.75) 100%);
	filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#80ffffff', endColorstr='#80d6d6d6',GradientType=0 );
}
.structure-page-editor-place:hover .tip {
	color:#222;
	box-shadow:0px 0px 1px rgba(0, 0, 0, 0.8);
	background:-moz-linear-gradient(top,  rgba(255,255,255,0.95) 0%, rgba(214,214,214,1) 100%);
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0.95)), color-stop(100%,rgba(214,214,214,1)));
	background:-webkit-linear-gradient(top,  rgba(255,255,255,0.95) 0%,rgba(214,214,214,0.) 100%);
	background:-o-linear-gradient(top,  rgba(255,255,255,0.95) 0%,rgba(214,214,214,1) 100%);
	background:-ms-linear-gradient(top,  rgba(255,255,255,0.95) 0%,rgba(214,214,214,1) 100%);
	background:linear-gradient(to bottom,  rgba(255,255,255,0.95) 0%,rgba(214,214,214,1) 100%);
	filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#80ffffff', endColorstr='#80d6d6d6',GradientType=0 );
}
</style>
