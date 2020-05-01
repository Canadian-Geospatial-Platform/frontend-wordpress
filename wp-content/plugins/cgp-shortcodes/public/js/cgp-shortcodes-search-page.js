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
      <input style="max-width:100%;" v-model="inputValue" v-on:keyup.enter="addFilter(fieldName, inputValue)" \
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
      '<label class="btn btn-primary" :class="{ active: checked }">\
      <input type="checkbox" class="form-check-input" v-model="checked"  v-on:change="stateChange">\
      {{ title }}</div>\
      </label>',
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
        console.log(this.checked);
        this.$emit("stateChange", this.title, this.checked);
      },
    },
  });

  var cgpOptionsFilters = Vue.component("cgp-options-filters", {
    template:
      '<div>\
      <h4>{{ filterData.title }}</h4>\
      <div class="btn-group-vertical btn-group-toggle" style="width: 100%;">\
      <cgp-options-filter v-for="option in filterData.options" v-bind:key="option" v-on:stateChange=updateFilter :title="option"/>\
      </div>\
      </div>',
    props: {
      fieldName: { required: true, type: String },
      filterData: { required: true, type: Object },
    },
    data: function () {
      return {};
    },
    methods: {
      updateFilter: function (title, checked) {
        if (checked) {
          this.$emit("addFilter", this.fieldName, title);
        } else {
          this.$emit(
            "removeFilter",
            this.fieldName,
            this.filterData.values.indexOf(title)
          );
        }
      },
    },
  });

  var cgpFilters = Vue.component("cgp-filters", {
    template:
      '<div><div class="card" v-if="hidden == false">\
      <div class="row"><div class="col"><h2>Filters</h2></div><button type="button" class="btn btn-light btn-sm rounded-circle"><div class="col text-right" @click="hidden = true">\
      <svg class="bi bi-x" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">\
      <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z" clip-rule="evenodd"/>\
      <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z" clip-rule="evenodd"/>\
      </svg>\
      </div></button></div>\
      <div v-for="( value, keyname ) in query" v-bind:key="keyname">\
      <cgp-text-filter v-if="value.type==\'text\'" \
      v-on:removeFilter="removeFilter" v-on:addFilter="addFilter" :fieldName="keyname" :filterData="value"/>\
      <cgp-options-filters v-if="value.type==\'multipleselect\'"\
      v-on:removeFilter="removeFilter" v-on:addFilter="addFilter" :fieldName="keyname" :filterData="value"/>\
      </div></div><div v-if="hidden == true" @click="hidden = false" class="card rounded-circle">\
      <svg class="bi bi-search" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">\
      <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 011.415 0l3.85 3.85a1 1 0 01-1.414 1.415l-3.85-3.85a1 1 0 010-1.415z" clip-rule="evenodd"/>\
      <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 100-11 5.5 5.5 0 000 11zM13 6.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" clip-rule="evenodd"/>\
      </svg>\
      </div></div></div>',
    props: { query: { required: true, type: Object } },
    data: function () {
      return {
        hidden: false,
      };
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

  var cgpResultField = Vue.component("cgp-result-field", {
    template:
      '<div>\
      <h5>{{ title }}</h5>\
      <div v-for="value in values" class="row"><div class="col">{{ value }}</div></div>\
      </div>',
    props: {
      title: { required: true, type: String },
      values: { required: true, type: Array },
    },
  });

  var cgpResultFieldGroup = Vue.component("cgp-result-field-group", {
    template:
      '<div class="row">\
      <cgp-result-field v-for="(field, index) in fields" :key="index" :title="field.title" :values="field.values" />\
      </div>',
    props: {
      fields: { required: true, type: Array },
    },
  });

  var cgpResultFieldGroupView = Vue.component("cgp-result-field-group-view", {
    template:
      '<div><cgp-result-field-group v-if="display == \'metadata\'" :fields="metadata.fields" />\
      <cgp-result-field-group v-if="display == \'contact\'" :fields="contact.fields" /></div>',
    props: {
      item: { required: true, type: Object },
      display: { required: true, type: String },
    },
    computed: {
      metadata: function () {
        return {
          fields: [
            { title: "Id", values: [this.item.properties.id] },
            { title: "Language", values: [this.item.properties.language] },
            {
              title: "Topic Category",
              values: [this.item.properties.topiccategory],
            },
            {
              title: "Tags",
              values: this.item.tags,
            },
            {
              title: "Duration",
              values: [
                "From: " + this.item.properties.datestart,
                "To: " + this.item.properties.dateend,
              ],
            },
            {
              title: "Type",
              values: [this.item.properties.type],
            },
            {
              title: "Use Limits",
              values: [this.item.properties.uselimits.en],
            },
            {
              title: "Published",
              values: [this.item.properties.published],
            },
            {
              title: "Maintenance",
              values: [this.item.properties.maintenance],
            },
            {
              title: "Status",
              values: [this.item.properties.status],
            },
          ],
        };
      },
      contact: function () {
        return {
          fields: [
            {
              title: "Organisation",
              values: [this.item.properties.organisationname.en],
            },
            {
              title: "City",
              values: [this.item.properties.city],
            },
            {
              title: "Province/Territory",
              values: [this.item.properties.pt.en],
            },
            {
              title: "Postal Code",
              values: [this.item.properties.postalcode],
            },

            {
              title: "Phone",
              values: ["From: " + this.item.properties.phone],
            },
            {
              title: "Individual Name",
              values: [this.item.properties.individualname],
            },
            {
              title: "Email",
              values: [this.item.properties.email],
            },
            {
              title: "Address",
              values: [this.item.properties.address],
            },
          ],
        };
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
      '<div>\
      <div v-for="resource in resources" >\
      <div class="row"><div class="col">\
      <cgp-result-resource :resource="resource"/>\
      </div></div></div></div>',
    props: { resources: { required: true, type: Array } },
  });

  var cgpResultExtendedView = Vue.component("cgp-result-extended-view", {
    template:
      '<div><cgp-result-resources v-show="display == \'resources\'" :resources="item.properties.resources" /> \
    <cgp-result-field-group-view v-show="display == \'metadata\' || display == \'contact\'" \
    :item="item" :display="display" />\
    </div>',
    props: {
      item: { required: true, type: Object },
      display: { type: String },
    },
    data() {
      return {};
    },
  });

  var cgpResultDataSelector = Vue.component("cgp-result-data-selector", {
    template:
      '<div><div v-if="show" class="card"><div class="btn-group" role="group" aria-label="Additional info" style="width: 100%">\
    <button type="button" class="btn btn-primary" :class="{active: display == \'metadata\'}" \
    v-on:click="display = \'metadata\';">Metadata</button>\
    <button type="button" class="btn btn-primary" :class="{active: display == \'resources\'}" \
    v-on:click="display = \'resources\';">Resources</button>\
    <button type="button" class="btn btn-primary" :class="{active: display == \'contact\'}" \
    v-on:click="display = \'contact\';">Contact</button>\
    </div><cgp-result-extended-view :display="display" :item="item" /> \
    </div><div v-else class="text-center mt-4"><button type="button" class="btn btn-primary btn-block" \
    v-on:click="show = true">Show More</button></div>\
    </div>',
    props: { item: { required: true, type: Object } },
    data() {
      return {
        display: "metadata",
        show: false,
      };
    },
  });

  var cgpResult = Vue.component("cgp-result", {
    template:
      '<div class="card p-4">\
      <div class="card-header mb-3 row"><div class="col"><h4 class="card-title">\
      <p>{{ item.properties.title.en }}</p>\
      </h4></div><div class="col-1"><button  class="btn btn-sm" @click="expand">\
      <svg v-show="!expandedView" class="bi bi-arrows-angle-expand" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">\
      <path fill-rule="evenodd" d="M1.5 10.036a.5.5 0 01.5.5v3.5h3.5a.5.5 0 010 1h-4a.5.5 0 01-.5-.5v-4a.5.5 0 01.5-.5z" clip-rule="evenodd"/>\
      <path fill-rule="evenodd" d="M6.354 9.646a.5.5 0 010 .708l-4.5 4.5a.5.5 0 01-.708-.708l4.5-4.5a.5.5 0 01.708 0zm8.5-8.5a.5.5 0 010 .708l-4.5 4.5a.5.5 0 01-.708-.708l4.5-4.5a.5.5 0 01.708 0z" clip-rule="evenodd"/>\
      <path fill-rule="evenodd" d="M10.036 1.5a.5.5 0 01.5-.5h4a.5.5 0 01.5.5v4a.5.5 0 11-1 0V2h-3.5a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>\
      </svg>\
      <svg v-show="expandedView" class="bi bi-arrows-angle-contract" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">\
      <path fill-rule="evenodd" d="M9.5 2.036a.5.5 0 01.5.5v3.5h3.5a.5.5 0 010 1h-4a.5.5 0 01-.5-.5v-4a.5.5 0 01.5-.5z" clip-rule="evenodd"/>\
      <path fill-rule="evenodd" d="M14.354 1.646a.5.5 0 010 .708l-4.5 4.5a.5.5 0 11-.708-.708l4.5-4.5a.5.5 0 01.708 0zm-7.5 7.5a.5.5 0 010 .708l-4.5 4.5a.5.5 0 01-.708-.708l4.5-4.5a.5.5 0 01.708 0z" clip-rule="evenodd"/>\
      <path fill-rule="evenodd" d="M2.036 9.5a.5.5 0 01.5-.5h4a.5.5 0 01.5.5v4a.5.5 0 01-1 0V10h-3.5a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>\
      </svg>\
      </button></div></div>\
      <h5 class="pt-3">Description </h5>\
      {{ item.properties.description.en }}\
      <h5 class="pt-3">Theme </h5>\
      {{ item.properties.topiccategory }}\
      <cgp-result-data-selector :item="item" />\
      </div>',
    props: {
      item: { required: true, type: Object },
      index: { required: true, type: Number },
      expandedView: { required: true, type: Boolean },
    },
    data: function () {
      return {};
    },
    methods: {
      expand: function () {
        this.$emit("expand", this.index);
      },
    },
  });

  var cgpResults = Vue.component("cgp-results", {
    template:
      '<div>\
      <div class="card" v-if="items.length == 0"><h3>Your results will be displayed here...</h3>\
      </div>\
      <div v-else><cgp-result v-for="(item, index) in items" v-bind:key="index" \
      v-show="focusedIndex == -1 || focusedIndex == index"  v-on:expand="expand"  :item="item" :index="index" :expandedView="expandedView" />\
      </div>\
      </div>',
    props: {
      items: { required: true, type: Array },
      expandedView: { required: true, type: Boolean },
    },
    data() {
      return {
        focusedIndex: -1,
      };
    },
    mounted: function () {
      if (this.expandedView) this.focusedIndex = 0;
    },
    methods: {
      expand: function (index) {
        if (this.focusedIndex == -1) this.focusedIndex = index;
        else this.focusedIndex = -1;
        this.$emit("expand");
      },
    },
  });

  var vm = new Vue({
    el: document.querySelector("#cgp-search-page"),
    template:
      '<div class="row">\
      <div class="col-12 col-lg-5 col-xl-4"><cgp-filters  v-show="!expandedView" v-on:removeFilter="removeFilter" v-on:addFilter="addFilter" :query="query"/></div>\
      <div class="col-12 col-lg-7 col-xl-8"><cgp-results :items="result.Items" :expandedView="expandedView" v-on:expand="expandedView = !expandedView"/></div>\
      </div>',
    mounted: function () {
      if (sessionStorage.getItem("cgpShortcodesSearchTermsKeyword")) {
        this.addFilter(
          "keywords",
          sessionStorage.getItem("cgpShortcodesSearchTermsKeyword")
        );
        sessionStorage.removeItem("cgpShortcodesSearchTermsKeyword");
      }
      if (sessionStorage.getItem("cgpShortcodesSearchTermsTheme")) {
        this.addFilter(
          "themes",
          sessionStorage.getItem("cgpShortcodesSearchTermsTheme")
        );
        sessionStorage.removeItem("cgpShortcodesSearchTermsTheme");
      }
      if (sessionStorage.getItem("cgpShortcodesSearchTermsId")) {
        this.addFilter(
          "id",
          sessionStorage.getItem("cgpShortcodesSearchTermsId")
        );
        this.expandedView = true;
        sessionStorage.removeItem("cgpShortcodesSearchTermsId");
      }
    },
    data: function () {
      return {
        expandedView: false,
        query: {
          id: {
            title: "Id",
            values: [],
            type: "text",
          },
          keywords: {
            title: "Keywords",
            values: [],
            type: "text",
          },
          tags: {
            title: "Tags",
            values: [],
            type: "text",
          },
          themes: {
            title: "Themes",
            values: [],
            options: [
              "Administration",
              "Economy",
              "Emergency",
              "Environment",
              "Imagery",
              "Infrastructure",
              "Legal",
              "Science",
              "Society",
            ],
            type: "multipleselect",
          },
        },
        result: {
          Items: [],
        },
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
          select: ["properties", "tags"],
          id: this.query.id.values,
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
