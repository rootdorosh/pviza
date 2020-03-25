<template>
  <Auth
    :title="$t('login.remind.password')"
  >
    <main-content
      class="widget-auth mx-auto"
      customHeader
    >
      <form class="mt" @submit.prevent="remindSubmit">
        <template v-if="isEmailForm">
          <div class="form-group">
            <input
              class="form-control no-border"
              :class="{'is-invalid': errorMessage.email}"
              ref="email"
              type="email"
              name="email"
              :placeholder="$t('placeholder.email')"
              v-model="email"
            />
            <span class="text-danger" v-if="errorMessage.email">
              {{ errorMessage.email[0] }}
            </span>
          </div>
        </template>
        <template v-else>
          <template v-if="!isSuccessForm">
            <div class="form-group">
              <input
                class="form-control no-border"
                :class="{'is-invalid': errorMessage.code}"
                ref="code"
                type="text"
                name="code"
                :placeholder="$t('placeholder.code')"
                v-model="code"
              />
              <span class="text-danger" v-if="errorMessage.code">
                {{ errorMessage.code[0] }}
              </span>
            </div>
            <div class="form-group">
              <input
                class="form-control no-border"
                :class="{'is-invalid': errorMessage.password}"
                ref="password"
                type="password"
                name="password"
                :placeholder="$t('placeholder.password')"
                v-model="password"
              />
              <span class="text-danger" v-if="errorMessage.password">
                {{ errorMessage.password[0] }}
              </span>
            </div>
          </template>
          <template v-else>
            <p class="text-center">
              {{ $t('form_remind.success') }}
            </p>
          </template>
        </template>
        <b-button type="submit" size="sm" class="auth-btn mb-3" variant="inverse" v-if="!isSuccessForm">{{ isFetching ? $t('loading') : $t('send') }}</b-button>
      </form>
      <div class="text-center">
        <router-link to="/auth/login">{{ $t('login') }}</router-link>
      </div>
    </main-content>
  </Auth>
</template>

<script>
import Auth from '@/components/Auth/Auth';
import { mapState, mapActions, mapMutations } from 'vuex';

export default {
  name: 'RemindPassword',
  components: { Auth },
  data() {
    return {
      email: '',
      code: '',
      password: '',
    }
  },
  computed: {
    ...mapState('remindPassword', {
      isFetching: state => state.isFetching,
      errorMessage: state => state.errorMessage,
      isEmailForm: state => state.isEmailForm,
      isSuccessForm: state => state.isSuccessForm,
    })
  },
  methods: {
    ...mapActions('remindPassword', ['remindSend']),
    ...mapMutations('remindPassword', ['remindReset']),
    remindSubmit() {
      let email = this.email;
      let code = this.code;
      let password = this.password;

      if (this.isEmailForm) {
        this.remindSend({ email });
      } else {
        this.remindSend({ code, password });
      }

      if (this.isSuccessForm) {
        this.email = this.code = this.password = '';
      }
    },
  },
  mounted() {
    this.remindReset();
  },
}
</script>
