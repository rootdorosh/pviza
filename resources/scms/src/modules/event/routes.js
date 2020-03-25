import EventEventIndex from './views/event/Index/Index'
import EventEventUpdate from './views/event/Update/Update'
import EventQueueIndex from './views/queue/Index/Index'

export default [
  {
    path: '/event/events',
    name: 'eventEventIndex',
    component: EventEventIndex,
  },
  {
    path: '/event/events/:id',
    name: 'eventEventUpdate',
    component: EventEventUpdate,
  },
  {
    path: '/event/queue',
    name: 'eventQueueIndex',
    component: EventQueueIndex,
  }];