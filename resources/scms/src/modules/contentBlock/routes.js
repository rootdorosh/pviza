import ContentBlockContentBlockIndex from './views/contentBlock/Index/Index'
import ContentBlockContentBlockCreate from './views/contentBlock/Create/Create'
import ContentBlockContentBlockUpdate from './views/contentBlock/Update/Update'

export default [
  {
    path: '/content-block/content-blocks',
    name: 'contentBlockContentBlockIndex',
    component: ContentBlockContentBlockIndex,
  },
  {
    path: '/content-block/content-blocks/create',
    name: 'contentBlockContentBlockCreate',
    component: ContentBlockContentBlockCreate,
  },
  {
    path: '/content-block/content-blocks/:id',
    name: 'contentBlockContentBlockUpdate',
    component: ContentBlockContentBlockUpdate,
  }];