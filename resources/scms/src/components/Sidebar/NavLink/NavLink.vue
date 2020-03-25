<template>
  <li v-if="!children && isHeader" :class="{headerLink: true, className}">
    <router-link :to="route" class="sidebar-link">
      <span class="icon">
        <i :class="fullIconName"></i>
      </span>
      {{title}} <sup v-if="label" :class="'text-' + labelColor" class="headerLabel">{{label}}</sup>
      <b-badge v-if="badge" class="badge rounded-f" variant="warning" pill>{{badge}}</b-badge>
    </router-link>
  </li>
  <li v-else-if="children" :class="{headerLink: true, className}">
    <div>
      <router-link :to="route" class="d-flex sidebar-link">
        <span class="icon">
          <i :class="fullIconName"></i>
        </span>
        {{title}} <sup v-if="label" :class="'text-' + labelColor" class="ml-1 headerLabel">{{label}}</sup>
      </router-link>
    </div>
    <b-collapse id="collapse" :visible="isActive">
      <ul class="sub-menu">
        <NavLink v-for="link in children"
          :activeItem="activeItem"
          :title="link.title"
          :index="link.index"
          :route="link.route"
          :children="link.children"
          :key="link.link"
        />
      </ul>
    </b-collapse>
  </li>
  <li v-else>
    <router-link :to="index !== 'menu' && route">
      {{title}} <sup v-if="label" :class="'text-' + labelColor" class="headerLabel">{{label}}</sup>
    </router-link>
  </li>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  name: 'NavLink',
  props: {
    badge: { type: String, dafault: '' },
    title: { type: String, default: '' },
    iconName: { type: String, default: '' },
    headerLink: { type: String, default: '' },
    route: { type: String, default: '' },
    children: { type: Array, default: null },
    className: { type: String, default: '' },
    isHeader: { type: Boolean, default: false },
    deep: { type: Number, default: 0 },
    activeItem: { type: String, default: '' },
    label: { type: String },
    labelColor: { type: String, default: 'warning' },
    index: { type: String },
  },
  data() {
    return {
      headerLinkWasClicked: true,
    };
  },
  methods: {
    ...mapActions('layout', ['changeSidebarActive']),
    togglePanelCollapse(link) {
      this.changeSidebarActive(link);
      this.headerLinkWasClicked = !this.headerLinkWasClicked
      || !this.activeItem.includes(this.index);
    },
  },
  computed: {
    fullIconName() {
      return `fi ${this.iconName}`;
    },
    isActive() {
      return (this.activeItem
      && this.activeItem.includes(this.index)
      && this.headerLinkWasClicked);
    },
  },
};
</script>

<style src="./NavLink.scss" lang="scss" scoped />
