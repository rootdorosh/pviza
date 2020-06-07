import ReviewReviewIndex from './views/review/Index/Index'
import ReviewReviewCreate from './views/review/Create/Create'
import ReviewReviewUpdate from './views/review/Update/Update'

export default [
  {
    path: '/review/reviews',
    name: 'reviewReviewIndex',
    component: ReviewReviewIndex,
  },
  {
    path: '/review/reviews/create',
    name: 'reviewReviewCreate',
    component: ReviewReviewCreate,
  },
  {
    path: '/review/reviews/:id',
    name: 'reviewReviewUpdate',
    component: ReviewReviewUpdate,
  }];