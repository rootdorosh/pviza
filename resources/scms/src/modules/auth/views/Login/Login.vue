<template>
  <Auth
    :title="$t('login.title')"
  >
    <main-content
      class="widget-auth mx-auto"
      customHeader
    >
      <form class="mt" @submit.prevent="submit">
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
        <b-button type="submit" size="sm" class="auth-btn mb-3" variant="inverse">{{ isFetching ? $t('loading') : $t('send') }}</b-button>
      </form>
      <div class="text-center">
        <router-link to="/auth/remind-password">{{ $t('remind.password') }}</router-link>
      </div>
    </main-content>
  </Auth>
</template>

<script>
import config from '@/config';
import Auth from '@/components/Auth/Auth';
import { mapState, mapActions } from 'vuex';

export default {
  name: 'Login',
  components: { Auth },
  data() {
    return {
      email: '',
      password: ''
    }
  },
  computed: {
    ...mapState('login', {
      isFetching: state => state.isFetching,
      errorMessage: state => state.errorMessage,
    })
  },
  methods: {
    ...mapActions('login', ['loginUser', 'receiveToken', 'receiveLogin']),
    submit() {
      let email = this.email;
      let password = this.password;

      this.loginUser({email, password});
    }
  },
  created() {
    const token = this.$route.query.token;

    if (token) {
      this.receiveToken(token);
    } else if (this.isAuthenticated(localStorage.getItem('token'))) {
      this.receiveLogin();
    }

    if (process.env.NODE_ENV !== 'production') {
      const auth = config.auth;

      if (auth) {
        this.email = auth.email;
        this.password = auth.password;
      }
    }
  }
};
</script>
