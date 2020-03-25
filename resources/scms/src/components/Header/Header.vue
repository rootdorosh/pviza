<template>
  <b-navbar class="header d-print-none">
    <b-nav>
      <b-nav-item>
        <a class="d-md-down-none px-2" href="#" @click="toggleSidebarMethod" id="barsTooltip">
          <i class='la la-bars la-lg' />
        </a>
        <a class="fs-lg d-lg-none" href="#" @click="switchSidebarMethod">
          <span class="rounded rounded-lg bg-gray text-white d-md-none">
            <i class="la la-bars la-lg" />
          </span>
          <i class="la la-bars la-lg d-sm-down-none ml-4" />
        </a>
      </b-nav-item>
    </b-nav>
    <a  class="navbarBrand d-md-none">
      <i class="fa fa-circle text-gray mr-n-sm" />
      <i class="fa fa-circle text-warning" />
      &nbsp;
      sing
      &nbsp;
      <i class="fa fa-circle text-warning mr-n-sm" />
      <i class="fa fa-circle text-gray" />
    </a>
    <b-nav class="ml-auto">
      <b-nav-item-dropdown class="settingsDropdown d-sm-down-none" no-caret right>
        <template slot="button-content">
          <span class="avatar rounded-circle thumb-sm float-left mr-2">
            <img
                v-if="$user.data.image"
                class="rounded-circle"
                :src="getUserImage()"
                :alt="$user.data.name"
            />
            <span v-else>{{ $user.data.name.charAt(0) }}</span>
          </span>
          <span class="small">{{ $user.data.name }}</span>
          <i class="la la-cog px-2" />
        </template>
        <template v-if="$user.data.id != adminId">
          <b-dropdown-item :to="'/user/users/' + $user.data.id"><i class="la la-user" /> {{ $t('my.account') }}</b-dropdown-item>
          <b-dropdown-divider />
        </template>
        <b-dropdown-item
          v-for="item of $user.menu.header"
          :to="item.route"
        >
          <i class="la" :class="item.icon" v-if="item.icon" /> {{ item.title }}
        </b-dropdown-item>
        <b-dropdown-divider />
        <b-dropdown-item-button @click="logoutUser">
          <i class="la la-sign-out" /> {{ $t('log.out') }}
        </b-dropdown-item-button>
      </b-nav-item-dropdown>
    </b-nav>
  </b-navbar>
</template>

<script>
import config from '@/config';
import { mapState, mapActions } from 'vuex';

export default {
  name: 'Header',
  computed: {
    ...mapState('layout', ['sidebarClose', 'sidebarStatic']),
    ...mapState('userUsersIndex', {
      adminId: state => state.adminId,
    }),
  },
  methods: {
    ...mapActions('layout', ['toggleSidebar', 'switchSidebar', 'changeSidebarActive']),
    ...mapActions('login', ['logoutUser']),
    switchSidebarMethod() {
      if (!this.sidebarClose) {
        this.switchSidebar(true);
        this.changeSidebarActive(null);
      } else {
        this.switchSidebar(false);
        const paths = this.$route.fullPath.split('/');
        paths.pop();
        this.changeSidebarActive(paths.join('/'));
      }
    },
    toggleSidebarMethod() {
      if (this.sidebarStatic) {
        this.toggleSidebar();
        this.changeSidebarActive(null);
      } else {
        this.toggleSidebar();
        const paths = this.$route.fullPath.split('/');
        paths.pop();
        this.changeSidebarActive(paths.join('/'));
      }
    },
    getUserImage() {
      return config.url + this.$user.data.image;
    },
  },
};
</script>

<style src="./Header.scss" lang="scss" scoped />
