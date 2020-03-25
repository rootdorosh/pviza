export default function(obj, isArray = true) {
  let target = {};

  if (isArray) {
    for (let key in obj) {
      Object.assign(target, obj[key]);
    }
  } else {
    target = obj;
  }

  return JSON.parse(JSON.stringify(target));
}
