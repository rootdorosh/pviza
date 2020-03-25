import TranslationTranslationIndex from './views/translation/Index/Index'
import TranslationTranslationCreate from './views/translation/Create/Create'
import TranslationTranslationUpdate from './views/translation/Update/Update'

export default [
  {
    path: '/translation/translations',
    name: 'translationTranslationIndex',
    component: TranslationTranslationIndex,
  },
  {
    path: '/translation/translations/create',
    name: 'translationTranslationCreate',
    component: TranslationTranslationCreate,
  },
  {
    path: '/translation/translations/:id',
    name: 'translationTranslationUpdate',
    component: TranslationTranslationUpdate,
  }];