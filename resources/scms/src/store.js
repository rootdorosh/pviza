import Vue from 'vue';
import Vuex from 'vuex';

import layout from '@/components/Layout/store';
import alert from '@/components/Alert/store';
import index from '@/components/Index/store';

import advantageCategoryIndex from '@/modules/advantage/store/category/index';
import advantageCategoryForm from '@/modules/advantage/store/category/form';
import advantageAdvantageIndex from '@/modules/advantage/store/advantage/index';
import advantageAdvantageForm from '@/modules/advantage/store/advantage/form';
import login from '@/modules/auth/store/login';
import remindPassword from '@/modules/auth/store/remind.password';
import contentBlockContentBlockIndex from '@/modules/contentBlock/store/contentBlock/index';
import contentBlockContentBlockForm from '@/modules/contentBlock/store/contentBlock/form';
import eventEventIndex from '@/modules/event/store/event/index';
import eventEventForm from '@/modules/event/store/event/form';
import eventQueueIndex from '@/modules/event/store/queue/index';
import menus from '@/modules/menu/store/menu/index';
import menuForm from '@/modules/menu/store/menu/form';
import settingsSettingsForm from '@/modules/settings/store/settings/form';
import structurePages from '@/modules/structure/store/page/index';
import structureDomainIndex from '@/modules/structure/store/domain/index';
import structureDomainForm from '@/modules/structure/store/domain/form';
import translationTranslationIndex from '@/modules/translation/store/translation/index';
import translationTranslationForm from '@/modules/translation/store/translation/form';
import userRolesIndex from '@/modules/user/store/role/index';
import userRolesForm from '@/modules/user/store/role/form';
import userUsersIndex from '@/modules/user/store/user/index';
import userUsersForm from '@/modules/user/store/user/form';
import vacancyCategoryIndex from '@/modules/vacancy/store/category/index';
import vacancyCategoryForm from '@/modules/vacancy/store/category/form';
import vacancyTypeIndex from '@/modules/vacancy/store/type/index';
import vacancyTypeForm from '@/modules/vacancy/store/type/form';
import vacancyLocationIndex from '@/modules/vacancy/store/location/index';
import vacancyLocationForm from '@/modules/vacancy/store/location/form';
import vacancyVacancyIndex from '@/modules/vacancy/store/vacancy/index';
import vacancyVacancyForm from '@/modules/vacancy/store/vacancy/form';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    layout,
    alert,
    index,
    advantageCategoryIndex,
    advantageCategoryForm,
    advantageAdvantageIndex,
    advantageAdvantageForm,
    login,
    remindPassword,
    contentBlockContentBlockIndex,
    contentBlockContentBlockForm,
    eventEventIndex,
    eventEventForm,
    eventQueueIndex,
    menus,
    menuForm,
    settingsSettingsForm,
    structurePages,
    structureDomainIndex,
    structureDomainForm,
    translationTranslationIndex,
    translationTranslationForm,
    userRolesIndex,
    userRolesForm,
    userUsersIndex,
    userUsersForm,
    vacancyCategoryIndex,
    vacancyCategoryForm,
    vacancyTypeIndex,
    vacancyTypeForm,
    vacancyLocationIndex,
    vacancyLocationForm,
    vacancyVacancyIndex,
    vacancyVacancyForm,
  },
});
