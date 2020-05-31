import ResumeResumeIndex from './views/resume/Index/Index'
import ResumeResumeView from './views/resume/View/View'

export default [
  {
    path: '/resume/resumes',
    name: 'resumeResumeIndex',
    component: ResumeResumeIndex,
  },
  {
    path: '/resume/resumes/:id/view',
    name: 'resumeResumeView',
    component: ResumeResumeView,
  }];