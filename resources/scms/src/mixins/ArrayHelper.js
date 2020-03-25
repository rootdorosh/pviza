export const ArrayHelper = {
  methods: {
    toMapParentsFromTree: function (data, depth='') {
      var inlineData = {};

      data.forEach((item, index) => {
          let currItem = JSON.parse(JSON.stringify(item));
          let curDepth = depth === '' ? `${index}` : `${depth}_${index}`

          let spl = curDepth.split('_');
          spl.pop();

          delete currItem.children;
          currItem.id = curDepth
          currItem.parent_id = spl.join('_')

          inlineData[curDepth] = currItem;
          /*
          inlineData[curDepth] = {
            id: curDepth,
            parent_id: currItem.parent_id,
            name: currItem.name
          };
          */

          if (typeof item.children === 'object') {
            inlineData = this.objectAddItems(inlineData, this.toMapParentsFromTree(item.children, curDepth));
          }
        })

        return inlineData;
    },

    toTree: function (elements, parentId = '') {
      let branch = [];

      for (let key in elements) {
        let element = elements[key];
        let elemParentId = element['parent_id'];
        if (elemParentId === null) {
          elemParentId = '';
        }

        if (elemParentId == parentId) {
          let children = this.toTree(elements, element['id']);
          if (children) {
            element['children'] = children;
          }
          branch.push(element);
        }
      }

      return branch;
    },

    objectAddItems: function (object, items) {
      for (let key in items) {
        object[key] = items[key];
      }
      return object;
    },

    optionFromValueTextToIdText: function (items) {
      data = [];
      for (let key in items) {
        data.push({
          id: items[key].value,
          text: items[key].text,
        });
      }
      return data;
    },

  }
}
