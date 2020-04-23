(function () {
  var cgpPill = Vue.component("cgp-pill", {
    template:
      '<button v-on:click="$emit(\'removeFilter\')" class="p-2 badge badge-pill \
      badge-primary text-break">\
    {{ fieldName }}\
    <span aria-hidden="true"> &times;</span>\
    </button>',
    props: { fieldName: String },
  });

  var cgpTextFilter = Vue.component("cgp-text-filter", {
    template:
      '<div>\
      <h4>{{ filterData.title }}</h4>\
      <input v-model="inputValue" v-on:keyup.enter="addFilter(fieldName, inputValue)" \
      :placeholder="fieldName" class="m-2">\
      <div class="d-flex justify-content-start flex-wrap">\
      <cgp-pill class="p-1" v-for="(filter, index) in filterData.values" v-bind:key="index"  \
      v-on:removeFilter="removeFilter(fieldName, index)" :field-name="filter" /></div>\
      </div>',
    props: {
      fieldName: { required: true, type: String },
      filterData: { required: true, type: Object },
    },
    data: function () {
      return {
        inputValue: "",
      };
    },
    methods: {
      addFilter: function (filter, value) {
        this.$emit("addFilter", filter, value);
        this.inputValue = "";
      },
      removeFilter: function (filter, index) {
        this.$emit("removeFilter", filter, index);
      },
    },
  });

  var cgpOptionsFilter = Vue.component("cgp-options-filter", {
    template:
      '<div class="form-check">\
      <input type="checkbox" class="form-check-input" v-model="checked" v-on:change="stateChange">\
      <label class="form-check-label" for="checkbox">{{ title }}</label></div>\
      </div>',
    props: {
      title: { required: true, type: String },
    },
    data: function () {
      return {
        checked: false,
      };
    },
    methods: {
      stateChange: function () {
        this.$emit("stateChange", this.title, this.checked, this.index);
      },
    },
  });

  var cgpOptionsFilters = Vue.component("cgp-options-filters", {
    template:
      '<div>\
      <h4>{{ filterData.title }}</h4>\
      <cgp-options-filter v-for="option in filterData.options" v-bind:key="option" v-on:stateChange=updateFilter :fieldName="fieldName" :title="option"/>\
      </div>',
    props: {
      fieldName: { required: true, type: String },
      filterData: { required: true, type: Object },
    },
    data: function () {
      return {};
    },
    methods: {
      updateFilter: function (title, checked, index) {
        if (checked) {
          this.$emit("addFilter", this.fieldName, title);
        } else {
          this.$emit(
            "removeFilter",
            this.fieldName,
            this.filterData.values.indexOf(this.fieldName)
          );
        }
      },
    },
  });

  var cgpFilters = Vue.component("cgp-filters", {
    template:
      '<div class="card">\
      <h2>Filters</h2>\
      <div v-for="( value, keyname ) in query" v-bind:key="keyname">\
      <cgp-text-filter v-if="value.type==\'text\'" \
      v-on:removeFilter="removeFilter" v-on:addFilter="addFilter" :fieldName="keyname" :filterData="value"/>\
      <cgp-options-filters v-if="value.type==\'multipleselect\'"\
      v-on:removeFilter="removeFilter" v-on:addFilter="addFilter" :fieldName="keyname" :filterData="value"/>\
      </div>\
      </div>',
    props: { query: { required: true, type: Object } },
    data: function () {
      return {};
    },
    methods: {
      addFilter: function (filter, value) {
        this.$emit("addFilter", filter, value);
      },
      removeFilter: function (filter, index) {
        this.$emit("removeFilter", filter, index);
      },
      queryField(fieldName) {
        return query[fieldName];
      },
    },
  });

  var cgpResultResource = Vue.component("cgp-result-resource", {
    template:
      '<div class="card p-4">\
      <div class="row m-3"><div class="col"><h4>{{ resource.name.en }}</h4></div></div>\
      <div class="row m-3"><div class="col"><h5>Type </h5> {{ resource.format }}\
      </div><div class="col"><h5>Description </h5> {{ resource.description.en }} </div>\
      <div class="col"><h5>Format </h5> {{ resource.format }}\
      </div><div class="col"><h5></h5><a :href="resource.url"><button class="btn btn-primary">Download</button></a></div></div>\
      </div></div>',
    props: { resource: { required: true, type: Object } },
  });

  var cgpResultResources = Vue.component("cgp-result-resources", {
    template:
      '<div><div><h3 style="display:inline">Resources</h3>\
      <a href="#" \
      v-on:click="hidden=!hidden">( {{ toggleKeyWord(hidden) }} )</a></div>\
      <div v-for="resource in resources" >\
      <div class="row"><div class="col">\
      <cgp-result-resource v-if="!hidden" :resource="resource"/>\
      </div></div></div></div>',
    props: { resources: { required: true, type: Array } },
    data: function () {
      return {
        hidden: true,
      };
    },
    methods: {
      toggleKeyWord(hidden) {
        if (hidden) {
          return "show";
        } else {
          return "hide";
        }
      },
    },
  });

  var cgpResult = Vue.component("cgp-result", {
    template:
      '<div class="card p-4">\
      <div class="card-header mb-3"><h4 class="card-title">\
      <p>{{ item.properties.title.en }}</p>\
      </h4></div>\
      <h5 class="pt-3">Description </h5>\
      {{ item.properties.description.en }}\
      <h5 class="pt-3">Theme </h5>\
      {{ item.properties.topiccategory }}\
      <h5 class="pt-3">Country </h5>\
      {{ item.properties.country }}\
      <h5 class="pt-3">Tags </h5>\
      {{ item.tags }}\
      <cgp-result-resources :resources="item.properties.resources"/>\
      </div>',
    props: { item: { required: true, type: Object } },
  });

  var cgpResults = Vue.component("cgp-results", {
    template:
      '<div>\
      <div class="card" v-if="items.length == 0"><h3>Your results will be displayed here...</h3></div>\
      <div v-else><cgp-result v-for="item in items" v-bind:key="item.id" :item="item"/></div>\
      </div>',
    props: { items: { required: true, type: Array } },
  });

  var vm = new Vue({
    el: document.querySelector("#cgp-search-page"),
    template:
      '<div class="row"><div class="col-md-4">\
      <cgp-filters v-on:removeFilter="removeFilter" v-on:addFilter="addFilter" :query="query"/>\
      </div><div class="col-md-8"><cgp-results :items="result.Items"/></div>\
      </div>',
    mounted: function () {
      if (sessionStorage.getItem("cgpShortcodesSearchTermsKeyword"))
        this.addFilter(
          "keywords",
          sessionStorage.getItem("cgpShortcodesSearchTermsKeyword")
        );
      if (sessionStorage.getItem("cgpShortcodesSearchTermsTheme"))
        this.addFilter(
          "themes",
          sessionStorage.getItem("cgpShortcodesSearchTermsTheme")
        );
      sessionStorage.removeItem("cgpShortcodesSearchTermsKeyword");
      sessionStorage.removeItem("cgpShortcodesSearchTermsTheme");
    },
    data: function () {
      return {
        query: {
          keywords: {
            title: "Keywords",
            values: [],
            type: "text",
          },
          themes: {
            title: "Themes",
            values: [],
            type: "text",
          },
          tags: {
            title: "Tags",
            values: [],
            options: ["air", "water", "Lorem Ipsum"],
            type: "multipleselect",
          },
        },
        result: { Items: [] },
      };
    },
    methods: {
      addFilter: function (filter, value) {
        if (this.query[filter].values.indexOf(value) === -1) {
          this.query[filter].values.push(value);
          this.fetchData();
        }
        console.log(this.query);
      },
      removeFilter: function (filter, index) {
        this.query[filter].values.splice(index, 1);
        console.log(this.query);
        this.fetchData();
      },
      fetchData: function () {
        let url = new URL(
          "https://zq7vthl3ye.execute-api.ca-central-1.amazonaws.com/sta/geo"
        );

        let params = {
          select: [
            "properties.title",
            "properties.organisationname",
            "properties.description",
            "properties.topiccategory",
            "properties.resources",
            "tags",
          ],
          regex: this.query.keywords.values,
          themes: this.query.themes.values,
          tags: this.query.tags.values,
        };

        Object.keys(params).forEach((key) =>
          url.searchParams.append(key, JSON.stringify(params[key]))
        );

        fetch(url)
          .then((response) => {
            response.json().then((data) => {
              this.result = data;
              console.log(data);
            });
          })
          .catch((error) => console.log(`Failed because of: ${error}`));
      },
    },
  });
})();
