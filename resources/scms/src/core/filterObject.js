export default function(data, name) {
  let array = [];
  
  for (let key in data) {
    if (data[key][name]) {
      array.push(key);
    }
  }

  return array;
}
