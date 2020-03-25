<template>
  <div>
    <form @submit.prevent="onSubmit('save')">
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
        label-for="email"
        label-class="required"
        horizontal
        :label="meta.fields.email"
        :description="meta.description.email"
        :label-cols="2"
      >
        <b-form-input
          type="text"
          name="email"
          id="email"
          v-model="model.email"
          :state="fieldState('email')"
        />
        <b-form-invalid-feedback>{{ fieldState('email', true) }}</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group
        label-for="password"
        label-class="required"
        horizontal
        :label="meta.fields.password"
        :description="meta.description.password"
        :label-cols="2"
      >
        <b-form-input
          type="text"
          name="password"
          id="password"
          v-model="model.password"
          :state="fieldState('password')"
        />
        <b-form-invalid-feedback>{{ fieldState('password', true) }}</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group
        label-for="position"
        horizontal
        :label="meta.fields.position"
        :description="meta.description.position"
        :label-cols="2"
      >
        <b-form-input
          type="text"
          name="position"
          id="position"
          v-model="model.position"
          :state="fieldState('position')"
        />
        <b-form-invalid-feedback>{{ fieldState('password', true) }}</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group
        label-for="roles"
        horizontal
        :label="meta.fields.roles"
        :description="meta.description.roles"
        :label-cols="2"
      >
        <v-select
          name="roles"
          id="roles"
          :options="select.roles.options"
          :value="select.roles.selected"
          multiple
          @input="selectChange('roles', $event)"
        >
          <div slot="no-options">{{ $t('select.no.options') }}</div>
        </v-select>
      </b-form-group>

      <b-form-group
        label-for="events"
        horizontal
        :label="meta.fields.events"
        :description="meta.description.events"
        :label-cols="2"
      >
        <v-select
          name="roles"
          id="roles"
          :options="select.events.options"
          :value="select.events.selected"
          multiple
          @input="selectChange('events', $event)"
        >
          <div slot="no-options">{{ $t('select.no.options') }}</div>
        </v-select>
      </b-form-group>

      <b-form-group
        label-for="image_file"
        horizontal
        :label="meta.fields.image_file"
        :description="meta.description.image_file"
        :label-cols="2"
      >
        <input-file-preview
          name="image_file"
          :value="image.user"
          :alt="model.name"
        />
      </b-form-group>

      <b-form-group
        label-for="is-active"
        label-class="required"
        horizontal
        :label="meta.fields.is_active"
        :description="meta.description.is_active"
        :label-cols="2"
      >
        <b-form-radio-group
          id="is-active"
          name="is_active"
          :options="optionsNoYes"
          buttons
          button-variant="outline-primary"
          v-model="model.is_active"
        />
      </b-form-group>

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
import vSelect from 'vue-select';
import InputFilePreview from '@/components/FormElements/InputFilePreview/InputFilePreview';
import { bus } from '@/main';

export default {
  name: 'UserForm',
  components: { FormFooter, vSelect, InputFilePreview },
  computed: {
    ...mapState('userUsersForm', {
      meta: state => state.meta,
      model: state => state.model,
      isFetching: state => state.isFetching,
      errorMessage: state => state.errorMessage,
      select: state => state.select,
      image: state => state.image,
    }),
  },
  methods: {
    ...mapMutations('userUsersForm', ['setState']),
    ...mapActions('userUsersForm', ['onMeta', 'onSubmit', 'onCancel', 'onSaveExit', 'onRouteId']),
  },
  created() {
    this.onRouteId();

    if (this.model.is_active == '') {
      this.setState({
        model: {
          is_active: 1
        }
      });
    }

    this.onMeta();
  },
  mounted() {
    bus.$on('ifp::change', (data, isDelete) => {
      this.setState({
        model: {
          image_file: data
        }
      });

      if (isDelete) {
        this.model.is_delete_image_file = 1;
      } else {
        this.model.is_delete_image_file = 0;
      }
    });
  },
  beforeDestroy: function() {
    bus.$off('ifp::change');
  },
};
</script>
