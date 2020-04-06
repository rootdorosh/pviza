import BlogCategoryIndex from './views/category/Index/Index'
import BlogCategoryCreate from './views/category/Create/Create'
import BlogCategoryUpdate from './views/category/Update/Update'
import BlogBlogIndex from './views/blog/Index/Index'
import BlogBlogCreate from './views/blog/Create/Create'
import BlogBlogUpdate from './views/blog/Update/Update'

export default [
  {
    path: '/blog/categories',
    name: 'blogCategoryIndex',
    component: BlogCategoryIndex,
  },
  {
    path: '/blog/categories/create',
    name: 'blogCategoryCreate',
    component: BlogCategoryCreate,
  },
  {
    path: '/blog/categories/:id',
    name: 'blogCategoryUpdate',
    component: BlogCategoryUpdate,
  },
  {
    path: '/blog/blogs',
    name: 'blogBlogIndex',
    component: BlogBlogIndex,
  },
  {
    path: '/blog/blogs/create',
    name: 'blogBlogCreate',
    component: BlogBlogCreate,
  },
  {
    path: '/blog/blogs/:id',
    name: 'blogBlogUpdate',
    component: BlogBlogUpdate,
  }];