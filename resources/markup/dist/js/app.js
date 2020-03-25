Vue.config.productionTip = false;
Vue.config.devtools = false;

if (document.getElementById('product')) {

new Vue({
  el: '#product',
  data: {
		products: '',
		product: '',
		index: '',
		length: '',
    prevIndex: '',
    nextIndex: '',
    timeout: '',
    interval: '',
    counter: 0,
    countEnd: false,
    imgWebp: true,
    show: false
  },
	computed: {
    useWebp: function() {
      var app = this;
      var webp = new Image();

      webp.onload = webp.onerror = function() {
        if (webp.height == 2) {
          app.imgWebp = true;
        } else {
          app.imgWebp = false;
        }
      };

      webp.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
    }
	},
  mounted: function() {
    var app = this;

    this.useWebp;
		this.index = Number(this.$refs.index.dataset.index);

    axios
      .get('json/products.json')
      .then(function(response) {
      	app.products = response.data;
      	app.product = app.products[app.index];
				app.length = app.products.length;
        app.show = true;
        app.prevCounter();
        app.nextCounter();
      })
			.catch(function(error) {
				console.log(error);
			});
  },
	methods: {
		getPrevIndex: function() {
			var prevIndex = this.index - 1;

			return this.products[prevIndex] ? prevIndex : this.length - 1;
		},
		getNextIndex: function() {
			var nextIndex = this.index + 1;

			return this.products[nextIndex] ? nextIndex : 0;
		},
		switchPrev: function() {
			this.index = this.getPrevIndex();
			this.product = this.products[this.index];
      this.prevCounter();
		},
		switchNext: function() {
			this.index = this.getNextIndex();
			this.product = this.products[this.index];
      this.nextCounter();
		},
    prevCounter: function() {
      this.prevIndex = this.index - 1 != -1 ? (this.index + 1) - 1 : this.length;
    },
    nextCounter: function() {
      this.nextIndex = this.index + 1 < this.length ? (this.index + 1) + 1 : 1;
    },
    getImgUrl: function(object, format) {
      var object = this.product[object];
      var url = undefined;

      if (object) {
        if (format == 'webp') {
          url = object[0].webp;
        } else if (format == 'any') {
          url = object[0].any;
        }

        url = url.trim();
      }

      return url ? url : undefined;
    },
    countUp: function() {
      var app = this;

      clearTimeout(app.timeout);
      clearInterval(app.interval);

      app.counter = 0;
      app.countEnd = false;

      app.timeout = setTimeout(function() {
        app.interval = setInterval(function() {
          if (app.counter < app.product.counter) {
            app.counter++;
          } else {
            app.countEnd = true;

            clearTimeout(app.timeout);
            clearInterval(app.interval);
          }
        }, 100 - app.product.counter);
      }, 1000);
    }
	}
});

};
