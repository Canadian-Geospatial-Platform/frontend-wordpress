(function () {
  var cgpPill = Vue.component("cgp-pill", {
    template:
      '<button class="badge badge-pill badge-primary">\
    {{ fieldName }}\
    <span aria-hidden="true"> &times;</span>\
    </button>',
    props: ["fieldName"],
  });

  var cgpTextFilter = Vue.component("cgp-text-filter", {
    template:
      '<div>\
      <h4>{{ fieldName }}</h4>\
      <input v-model="inputValue" v-on:keyup.enter="addFilter()" :placeholder="fieldName">\
      <div v-for="filter in filters" v-bind:key="filter" v-on:click="filters = filters.filter(e => e !== filter )"><cgp-pill :field-name="filter" /></div>\
    </div>',
    props: ["fieldName"],
    data: function () {
      return {
        filters: [],
        inputValue: "",
      };
    },
    methods: {
      addFilter: function () {
        if (this.filters.indexOf(this.inputValue) === -1) {
          this.filters.push(this.inputValue);
        }
        this.inputValue = "";
      },
    },
  });

  var cgpFilters = Vue.component("cgp-filters", {
    template:
      '<div>\
			<cgp-text-filter v-for="field in fields.text" v-bind:key="field" :field-name="field"/>\
		</div>',
    data: function () {
      return {
        fields: {
          text: ["Keywords", "Theme"],
        },
      };
    },
  });

  var vm = new Vue({
    el: document.querySelector("#cgp-search-page"),
    template: "<div>\
    <h2>Filters</h2>\
    <cgp-filters/>\
    </div>",
    mounted: function () {
      console.log("Hello Vue!");
    },
    data: function () {
      return {};
    },
  });
})();
