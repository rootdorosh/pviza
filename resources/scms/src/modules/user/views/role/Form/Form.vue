<template>
  <div>
    <form @submit.prevent="onSubmit('save')">
      <b-tabs>
        <b-tab :title="$t('user.group')" active>
          <b-form-group
            label-for="name"
            label-class="required"
            horizontal
            :label="meta.fields.name"
            :description="meta.description.name"
            :label-cols="2"
          >
            <b-form-input
              type="text"
              name="name"
              id="name"
              v-model="model.name"
              :state="fieldState('name')"
            />
            <b-form-invalid-feedback>{{ fieldState('name', true) }}</b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
            label-for="slug"
            label-class="required"
            horizontal
            :label="meta.fields.slug"
            :description="meta.description.slug"
            :label-cols="2"
          >
            <b-form-input
              type="text"
              name="slug"
              id="slug"
              v-model="model.slug"
              :state="fieldState('slug')"
            />
            <b-form-invalid-feedback>{{ fieldState('slug', true) }}</b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
            label-for="description"
            horizontal
            :label="meta.fields.description"
            :description="meta.description.description"
            :label-cols="2"
          >
            <!-- <b-form-textarea
              :rows="3"
              name="description"
              id="description"
              v-model="model.description"
            /> -->

            <editor
              v-model="model.description"
            />
          </b-form-group>
        </b-tab>

        <b-tab :title="$t('user.permissions')" title-link-class="error">
          <b-form-group
            label-for="permissions"
            horizontal
            :label="meta.fields.permissions"
            :description="meta.description.permissions"
            :label-cols="2"
          >
            <ejs-treeview
              ref="permissions"
              :fields="nodes.permissions"
              :showCheckBox="true"
              :nodeClicked="onNodeChange"
            ></ejs-treeview>
          </b-form-group>
        </b-tab>
      </b-tabs>

      <form-footer
        :model="model"
        :isFetching="isFetching"
        @onCancel="onCancel"
        @onSaveExit="onSaveExit"
      />
    </form>
  </div>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex';
import FormFooter from '@/components/FormFooter/FormFooter';

export default {
  name: 'RoleForm',
  components: { FormFooter },
  computed: {
    ...mapState('userRolesForm', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errorMessage: state => state.errorMessage,
      nodes: state => state.nodes,
    }),
  },
  methods: {
    ...mapMutations('userRolesForm', ['setState', 'setDefaultState']),
    ...mapActions('userRolesForm', ['onMeta', 'onSubmit', 'onCancel', 'onSaveExit', 'onRouteId']),
    onNodeChange: function(args) {
      let treeObj = this.$refs.permissions.$el.ej2_instances[0];
      let checkedNode = [args.node];

      if (args.event.target.classList.contains('e-fullrow') || args.event.key == 'Enter') {
        let getNodeDetails = treeObj.getNodeData(args.node);

        if (getNodeDetails.isChecked == 'true') {
          treeObj.uncheckAll(checkedNode);
        } else {
          treeObj.checkAll(checkedNode);
        }
      }

      let permissions = treeObj.checkedNodes.filter(e => e != 0);

      this.setState({
        model: {
          permissions
        }
      });
    }
  },
  created() {
    this.onRouteId();
    this.onMeta();
  },
  watch: {
    nodes: {
      handler(data) {
        this.nodesRefresh(data);
      },
      deep: true
    },
  }
};
</script>
