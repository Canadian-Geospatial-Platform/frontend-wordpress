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

  var cgpResultField = Vue.component("cgp-result-field", {
    template:
      '<div class="col-md-3">\
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
      '<div><h3>{{ title }}</h3><div class="row">\
      <cgp-result-field v-for="(field, index) in fields" :key="index" :title="field.title" :values="field.values" />\
      </div></div>',
    props: {
      title: { required: true, type: String },
      fields: { required: true, type: Array },
    },
  });

  var cgpResultFieldGroupView = Vue.component("cgp-result-field-group-view", {
    template:
      '<div><cgp-result-field-group :title="metadata.title" :fields="metadata.fields" />\
      <cgp-result-field-group :title="contact.title" :fields="contact.fields" /></div>',
    props: { item: { required: true, type: Object } },
    computed: {
      metadata: function () {
        return {
          title: "Metadata",
          fields: [
            { title: "Language", values: [this.item.properties.language] },
            {
              title: "Published",
              values: [this.item.properties.published],
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
          title: "Contact",
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
      <cgp-result-field-group-view :item="item" />\
      <cgp-result-resources :resources="item.properties.resources"/>\
      </div>',
    props: { item: { required: true, type: Object } },
  });

  var cgpResults = Vue.component("cgp-results", {
    template:
      '<div>\
      <div class="card" v-if="items.length == 0"><h3>Your results will be displayed here...</h3>\
      </div>\
      <div v-else><cgp-result v-for="item in items" v-bind:key="item.id" :item="item"/></div>\
      </div>',
    props: { items: { required: true, type: Array } },
    data() {
      return {};
    },
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
        result: {
          Items: [
            {
              id: "7da452cc-0701-465d-b26d-d501f4f6e22a",
              properties: {
                topiccategory: "biota",
                country: "CanadaCanada (le)",
                organisationname: {
                  en: "Government of Canada; Fisheries and Oceans Canada",
                  fr: "Gouvernement du Canada; P�ches et Oc�ans Canada",
                },
                address:
                  "Pacific Biological Station,3190 Hammond Bay RoadLa station biologique du Pacifique, 3190, chemin Hammond BayNanaimoBritish ColumbiaColombie-BritanniqueV9T 6N7CanadaCanada (le)leslie.barton@dfo-mpo.gc.caleslie.barton@dfo-mpo.gc.ca",
                pt: {
                  en: "British Columbia",
                  fr: "Colombie-Britannique",
                },
                city: "Nanaimo",
                description: {
                  en:
                    "Survey for Physella wright - the hotwater physa, at Liard River Hotsprings Provincial Park, August 2006.",
                  fr:
                    "Relev� pour le Physella wrighti - de la physe d?eau chaude, � Liard River Hotsprings Provincial Park, Ao�t 2006.",
                },
                resources: [
                  {
                    format: "HTTPS",
                    name: {
                      en: "Data Dictionary",
                      fr: "Dictionnaire de donn�es",
                    },
                    description: {
                      en: "Supporting Document;HTML;eng,fra",
                      fr: "Document de soutien;HTML;eng,fra",
                    },
                    url:
                      "https://pacgis01.dfo-mpo.gc.ca/FGPPublic/Survey_for_Physella_Wrighti/Data_Dictionary_Physa_bi.htm",
                  },
                  {
                    format: "HTTPS",
                    name: {
                      en: "P.wrighti survey data",
                      fr:
                        "Donn�es du relev� sur la physe d?eau chaude (Physella wrighti)",
                    },
                    description: {
                      en: "Dataset;CSV;eng",
                      fr: "Donn�es;CSV;eng",
                    },
                    url:
                      "https://pacgis01.dfo-mpo.gc.ca/FGPPublic/Survey_for_Physella_Wrighti/Pwrighti_survey_data_2006.csv",
                  },
                  {
                    format: "HTTPS",
                    name: {
                      en: "P.wrighti survey data",
                      fr:
                        "Donn�es du relev� sur la physe d?eau chaude (Physella wrighti)",
                    },
                    description: {
                      en: "Dataset;CSV;fra",
                      fr: "Donn�es;CSV;fra",
                    },
                    url:
                      "https://pacgis01.dfo-mpo.gc.ca/FGPPublic/Survey_for_Physella_Wrighti/Pwrighti_survey_data_2006_FR.csv",
                  },
                  {
                    format: "HTTP",
                    name: {
                      en: "Species at Risk Public Library - Physella wrighti",
                      fr:
                        "Physella wrighti - Registre public des esp�ces en p�ril",
                    },
                    description: {
                      en: "Supporting Document;HTML;eng",
                      fr: "Document de soutien;HTML;eng",
                    },
                    url:
                      "http://www.sararegistry.gc.ca/species/speciesDetails_e.cfm?sid=548",
                  },
                  {
                    format: "HTTP",
                    name: {
                      en:
                        "Recovery Potential Assessment for Hotwater Physa (Physella wrighti)",
                      fr:
                        "�valuation du potentiel de r�tablissement de la physe d?eau chaude",
                    },
                    description: {
                      en: "Supporting Document;PDF;eng",
                      fr: "Document de soutien;PDF;eng",
                    },
                    url: "http://www.dfo-mpo.gc.ca/Library/339207.pdf",
                  },
                  {
                    format: "HTTP",
                    name: {
                      en: "Species at Risk Public Registry - Physella wrighti",
                      fr:
                        "Physella wrighti - Registre public des esp�ces en p�ril",
                    },
                    description: {
                      en: "Supporting Document;HTML;fra",
                      fr: "Document de soutien;HTML;fra",
                    },
                    url:
                      "http://www.sararegistry.gc.ca/species/speciesDetails_f.cfm?sid=548",
                  },
                  {
                    format: "ESRI REST: Map Service",
                    name: {
                      en: "Survey for Physella Wright",
                      fr: "Relev� pour le Physella wrighti",
                    },
                    description: {
                      en: "Web Service;ESRI REST;eng",
                      fr: "Service Web;ESRI REST;eng",
                    },
                    url:
                      "https://gisp.dfo-mpo.gc.ca/arcgis/rest/services/FGP/Survey_for_Physella_Wrighti/MapServer/0",
                  },
                  {
                    format: "ESRI REST: Map Service",
                    name: {
                      en: "Survey for Physella Wright",
                      fr: "Relev� pour le Physella wrighti",
                    },
                    description: {
                      en: "Web Service;ESRI REST;fra",
                      fr: "Service Web;ESRI REST;fra",
                    },
                    url:
                      "https://gisp.dfo-mpo.gc.ca/arcgis/rest/services/FGP/Survey_for_Physella_Wrighti/MapServer/1",
                  },
                ],
                language: "eng; CAN",
                dateend: "2006-12-20",
                published: "null",
                title: {
                  en:
                    "Survey for Physella wrighti - the hotwater physa, at Liard River Hotsprings Provincial Park, August 2006.",
                  fr:
                    "Relev� pour le Physella wrighti - de la physe d?eau chaude, � Liard River Hotsprings Provincial Park, Ao�t 2006.",
                },
                type: "dataset; jeuDonn�es",
                datestart: "2006-01-03",
                phone: "250-756-7306250-756-7306",
                uselimits: {
                  en:
                    "Open Government Licence - Canada (http://open.canada.ca/en/open-government-licence-canada)",
                  fr:
                    "Licence du gouvernement ouvert - Canada (http://ouvert.canada.ca/fr/licence-du-gouvernement-ouvert-canada)",
                },
                postalcode: "V9T 6N7",
                individualname: "Leslie Barton",
                id: "7da452cc-0701-465d-b26d-d501f4f6e22a",
                keyword: {
                  en: "PacificPacifique",
                  fr: "PacifiquePacifique",
                },
                maintenance: "notPlanned; nonPlanifi�",
                email: "leslie.barton@dfo-mpo.gc.caleslie.barton@dfo-mpo.gc.ca",
                status: "completed; compl�t�",
              },
              tags: ["water", "air"],
            },
          ],
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
