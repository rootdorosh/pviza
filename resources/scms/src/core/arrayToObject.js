export default function(array) {
  let object = {};

  for (let key in array) {
    object[array[key]] = '';
  }

  return object;
}
