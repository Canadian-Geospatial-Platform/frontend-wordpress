(function () {
  var cgpFilters = Vue.component("cgp-filters", {
    template:
      '<div class="pk-question">\
			<h2>atts.question</h2>\
			<button>Submit</button>\
		</div>',
    data: function () {
      return {
        selectedAnswer: null,
      };
    },
    methods: {},
  });

  var vm = new Vue({
    el: document.querySelector("#cgp-search-page"),
    template:
      '<div class="pk-container">\
    <cgp-filters/>\
    asdfasfdasfd\
    </div>',
    mounted: function () {
      console.log("Hello Vue!");
    },
  });
})();
