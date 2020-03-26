(function($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */

  $(window).load(function() {
    $("#cgp-search-btn").on("click", function() {
      console.log("called");
      const url =
        "https://zq7vthl3ye.execute-api.ca-central-1.amazonaws.com/sta/geo";
      const options = {
        method: "POST",
        headers: {
          "Content-Type": "text/plain;charset=UTF-8",
          Accept: "application/json"
        },
        body: JSON.stringify({
          regex: [
            {
              path: "properties.title.en",
              regex:
                "(?i).*(" +
                document.getElementById("cgp-filter-title").value +
                ").*"
            },
            {
              path: "properties.description.en",
              regex:
                "(?i).*(" +
                document.getElementById("cgp-filter-description").value +
                ").*"
            },
            {
              path: "properties.keyword.en",
              regex:
                "(?i).*(" +
                document.getElementById("cgp-filter-keyword").value +
                ").*"
            },
            {
              path: "properties.topiccategory",
              regex:
                "(?i).*(" +
                document.getElementById("cgp-filter-topic-category").value +
                ").*"
            }
          ],
          tags: document.getElementById("cgp-filter-tag").value.split("|"),
          select: [
            "properties.title",
            "tags",
            "properties.description",
            "popularityindex"
          ]
        })
      };
      fetch(url, options)
        .then(response => {
          response.json().then(data => {
            renderResults(data.Items);
          });
        })
        .catch(error => console.log(`Failed because of: ${error}`));
    });

    async function renderResults(Items) {
      let result = [];
      let i = 1;
      document.getElementById("metadata-search-result").innerHTML = "";
      Items.forEach(e => {
        i++;
        result.push(resultCard(e));
      });
      Promise.all(result).then(function(html) {
        html.forEach(e => {
          document.getElementById("metadata-search-result").innerHTML += e;
        });
      });
    }

    function resultCard(data) {
      let htmlString =
        '<div class="card">' +
        '<div class="card-body">' +
        '<h5 class="card-title">' +
        data.properties.title.en +
        "</h5>" +
        '<p class="card-text">' +
        data.properties.description.en +
        "</p>" +
        '<p class="card-text"> tags: ' +
        data.tags +
        "</p>" +
        "</div>";
      return htmlString;
    }
  });
})(jQuery);
