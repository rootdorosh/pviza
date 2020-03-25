import Vue from 'vue';
import flattenObject from '@/core/flattenObject.js';

export default function(state, object) {
  let data = flattenObject(object);

  for (let key in data) {
    let path = key.split('.');
    let length = path.length;
    let value = data[key];

    switch (length) {
      case 1:

        if (state[path[0]] !== undefined) {
          state[path[0]] = value;
        } else {
          Vue.set(state, path[0], value);
        }

        break;
      case 2:

        if (state[path[0]][path[1]] !== undefined) {
          state[path[0]][path[1]] = value;
        } else {
          Vue.set(state[path[0]], path[1], value);
        }

        break;
      case 3:

        if (state[path[0]][path[1]][path[2]] !== undefined) {
          state[path[0]][path[1]][path[2]] = value;
        } else {
          Vue.set(state[path[0]][path[1]], path[2], value);
        }

        break;
      case 4:

        if (state[path[0]][path[1]][path[2]][path[3]] !== undefined) {
          state[path[0]][path[1]][path[2]][path[3]] = value;
        } else {
          Vue.set(state[path[0]][path[1]][path[2]], path[3], value);
        }

        break;
      case 5:

        if (state[path[0]][path[1]][path[2]][path[3]][path[4]] !== undefined) {
          state[path[0]][path[1]][path[2]][path[3]][path[4]] = value;
        } else {
          Vue.set(state[path[0]][path[1]][path[2]][path[3]], path[4], value);
        }

        break;
      case 6:

        if (state[path[0]][path[1]][path[2]][path[3]][path[4]][path[5]] !== undefined) {
          state[path[0]][path[1]][path[2]][path[3]][path[4]][path[5]] = value;
        } else {
          Vue.set(state[path[0]][path[1]][path[2]][path[3]][path[4]], path[5], value);
        }

        break;
    }
  }
}
