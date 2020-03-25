import base from './State/Base';
import setState from '../Base/Mutations/SetState';
import setFailure from './Mutations/SetFailure';
import setSuccess from './Mutations/SetSuccess';
import onFailure from './Actions/OnFailure';
import onRequest from './Actions/OnRequest';
import onCancel from './Actions/OnCancel';
import onSaveExit from './Actions/OnSaveExit';
import onSuccess from './Actions/OnSuccess';
import onMeta from './Actions/OnMeta';
import onSubmitRequest from './Actions/OnSubmitRequest';
import onRouteId from './Actions/OnRouteId';

export const states = {
  base,
}

export const mutations = {
  setState,
  setFailure,
  setSuccess,
}

export const actions = {
  onFailure,
  onRequest,
  onCancel,
  onSaveExit,
  onSuccess,
  onMeta,
  onSubmitRequest,
  onRouteId
}
