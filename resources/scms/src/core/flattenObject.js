export default function flattenObject(obj) {
  var toReturn = {};

  for (var i in obj) {
    if (!obj.hasOwnProperty(i)) continue;

    if (obj[i] && obj[i].constructor == Object) {
      var flatObject = flattenObject(obj[i]);

      for (var x in flatObject) {
        if (!flatObject.hasOwnProperty(x)) continue;

        toReturn[i + '.' + x] = flatObject[x];
      }
    } else {
      toReturn[i] = obj[i];
    }
  }

  return toReturn;
}
