import FeedbackFeedbackView from './views/feedback/View/View'
import FeedbackFeedbackIndex from './views/feedback/Index/Index'

export default [
  {
    path: '/feedback/feedbacks/:id/view',
    name: 'feedbackFeedbackView',
    component: FeedbackFeedbackView,
  },
  {
    path: '/feedback/feedbacks',
    name: 'feedbackFeedbackIndex',
    component: FeedbackFeedbackIndex,
  }];