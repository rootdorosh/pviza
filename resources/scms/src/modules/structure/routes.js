import StructurePages from './views/page/Index/Index';
import StructureDomainIndex from './views/domain/Index/Index';
import StructureDomainCreate from './views/domain/Create/Create';
import StructureDomainUpdate from './views/domain/Update/Update';

export default [
  {
    path: '/structure/domains/:domainId/pages',
    name: 'StructureDomainPages',
    component: StructurePages,
  },
  {
    path: '/structure/domains/:domainId/pages/:pageId',
    name: 'StructureDomainPageView',
    component: StructurePages,
  },
  {
    path: '/structure/domains',
    name: 'Domains',
    component: StructureDomainIndex,
  },
  {
    path: '/structure/domains/create',
    name: 'DomainCreate',
    component: StructureDomainCreate,
  },
  {
    path: '/structure/domains/:id',
    name: 'DomainUpdate',
    component: StructureDomainUpdate,
  },
];
