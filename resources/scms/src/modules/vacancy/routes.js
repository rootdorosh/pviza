import VacancyCategoryIndex from './views/category/Index/Index'
import VacancyCategoryCreate from './views/category/Create/Create'
import VacancyCategoryUpdate from './views/category/Update/Update'
import VacancyTypeIndex from './views/type/Index/Index'
import VacancyTypeCreate from './views/type/Create/Create'
import VacancyTypeUpdate from './views/type/Update/Update'
import VacancyLocationIndex from './views/location/Index/Index'
import VacancyLocationCreate from './views/location/Create/Create'
import VacancyLocationUpdate from './views/location/Update/Update'
import VacancyVacancyIndex from './views/vacancy/Index/Index'
import VacancyVacancyCreate from './views/vacancy/Create/Create'
import VacancyVacancyUpdate from './views/vacancy/Update/Update'

export default [
  {
    path: '/vacancy/categories',
    name: 'vacancyCategoryIndex',
    component: VacancyCategoryIndex,
  },
  {
    path: '/vacancy/categories/create',
    name: 'vacancyCategoryCreate',
    component: VacancyCategoryCreate,
  },
  {
    path: '/vacancy/categories/:id',
    name: 'vacancyCategoryUpdate',
    component: VacancyCategoryUpdate,
  },
  {
    path: '/vacancy/types',
    name: 'vacancyTypeIndex',
    component: VacancyTypeIndex,
  },
  {
    path: '/vacancy/types/create',
    name: 'vacancyTypeCreate',
    component: VacancyTypeCreate,
  },
  {
    path: '/vacancy/types/:id',
    name: 'vacancyTypeUpdate',
    component: VacancyTypeUpdate,
  },
  {
    path: '/vacancy/locations',
    name: 'vacancyLocationIndex',
    component: VacancyLocationIndex,
  },
  {
    path: '/vacancy/locations/create',
    name: 'vacancyLocationCreate',
    component: VacancyLocationCreate,
  },
  {
    path: '/vacancy/locations/:id',
    name: 'vacancyLocationUpdate',
    component: VacancyLocationUpdate,
  },
  {
    path: '/vacancy/vacancies',
    name: 'vacancyVacancyIndex',
    component: VacancyVacancyIndex,
  },
  {
    path: '/vacancy/vacancies/create',
    name: 'vacancyVacancyCreate',
    component: VacancyVacancyCreate,
  },
  {
    path: '/vacancy/vacancies/:id',
    name: 'vacancyVacancyUpdate',
    component: VacancyVacancyUpdate,
  }];