import isScreen from '@/core/screenHelper';

const DashboardThemes = {
  LIGHT: "light",
  DARK: "dark"
};

export default {
  namespaced: true,
  state: {
    sidebarClose: false,
    sidebarStatic: true,
    sidebarActiveElement: null,
    dashboardTheme: DashboardThemes.DARK,
  },
  mutations: {
    toggleSidebar(state) {
      const nextState = !state.sidebarStatic;

      localStorage.sidebarStatic = nextState;
      state.sidebarStatic = nextState;

      if (!nextState && (isScreen('lg') || isScreen('xl'))) {
        state.sidebarClose = true;
      }
    },
    switchSidebar(state, value) {
      if (value) {
        state.sidebarClose = value;
      } else {
        state.sidebarClose = !state.sidebarClose;
      }
    },
    changeSidebarActive(state, index) {
      state.sidebarActiveElement = index;
    },
    handleSwipe(state, e) {
      if ('ontouchstart' in window) {
        if (e.direction === 4) {
          state.sidebarClose = false;
        }

        if (e.direction === 2 && !state.sidebarClose) {
          state.sidebarClose = true;

          return;
        }
      }
    },
  },
  actions: {
    toggleSidebar({ commit }) {
      commit('toggleSidebar');
    },
    switchSidebar({ commit }, value) {
      commit('switchSidebar', value);
    },
    changeSidebarActive({ commit }, index) {
      commit('changeSidebarActive', index);
    },
    handleSwipe({ commit }, e) {
      commit('handleSwipe', e);
    },
  },
};
