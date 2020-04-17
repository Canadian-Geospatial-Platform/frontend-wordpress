(function ($) {
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

  $(window).ready(function () {
    // var cgpShorcodesGlobalVars;

    const cgpShortcodesEnv = {
      apiUrl:
        "https://zq7vthl3ye.execute-api.ca-central-1.amazonaws.com/sta/geo",
      singleSearchResultPath: "/about-cgp",
    };

    let searchParams = {
      searchTerms: [],
      // bbox will be gotten in leaflet map
      bbox: null,
    };

    // If we are on a search result page, trigger stored search terms
    if (document.getElementById("cgp-shortcodes-simple-search")) {
      addSearchTerm(sessionStorage.getItem("cgpShortcodesSearchTerms"));
      sessionStorage.removeItem("cgpShortcodesSearchTerms");
    }

    function addSearchTerm(searchTerm) {
      if (!searchTerm || searchParams.searchTerms.indexOf(searchTerm) !== -1)
        return;
      searchParams.searchTerms.push(searchTerm);
      renderPill(searchTerm);
      updateResults();
    }

    /**
     * Removes search term
     **/
    $("#cgp-shortcodes-search-pills").on("click", "a", function (event) {
      searchParams.searchTerms = searchParams.searchTerms.filter(function (
        value
      ) {
        return value != event.srcElement.innerText;
      });
      event.currentTarget.remove();
      updateResults();
    });

    function renderPill(searchTerm) {
      document.getElementById("cgp-shortcodes-search-pills").innerHTML +=
        '<a href="#" class="badge badge-pill badge-primary"><span class="cgp-search-term">' +
        searchTerm +
        '</span><span aria-hidden="true"> &times;</span>' +
        "</a>";
      document.getElementById("cgp-filter-search-term").value = "";
    }

    $("#cgp-shortcodes-simple-search").submit(function (event) {
      event.preventDefault();
      addSearchTerm(document.getElementById("cgp-filter-search-term").value);
    });

    function updateResults() {
      let url = new URL(cgpShortcodesEnv.apiUrl);

      let params = {
        regex: [],
        select: [
          "properties.title",
          "properties.organisationname",
          "properties.description",
          "properties.topiccategory",
        ],
        tags: [],
      };

      searchParams.searchTerms.forEach((e) => {
        params.regex.push("(?i)\\b(" + e + ")\\b");
      });

      Object.keys(params).forEach((key) =>
        url.searchParams.append(key, JSON.stringify(params[key]))
      );

      fetch(url)
        .then((response) => {
          response.json().then((data) => {
            renderResults(data.Items);
          });
        })
        .catch((error) => console.log(`Failed because of: ${error}`));
    }

    function renderResults(Items) {
      document.getElementById("metadata-search-result").innerHTML = "";
      Items.forEach((e) => {
        document.getElementById(
          "metadata-search-result"
        ).innerHTML += resultCard(e);
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
        '<h6>Organisation: </h6><p class="card-text">  ' +
        data.properties.organisationname.en +
        "</p>" +
        '<h6>Theme: </h6><p class="card-text">  ' +
        data.properties.topiccategory +
        "</p>" +
        '<div class="text-center">' +
        '<form action="' +
        cgpShortcodesEnv.singleSearchResultPath +
        '" method="post">' +
        '<input type="hidden" name="id" value="' +
        data.id +
        '" />' +
        '<input type="submit" value="Detailed View"/>' +
        "</form>" +
        "</div></div>";
      return htmlString;
    }

    $("#cgp-shortcodes-redirect-search").submit(function (event) {
      event.preventDefault();
      sessionStorage.setItem(
        "cgpShortcodesSearchTerms",
        document.querySelector("#cgp-shortcodes-redirect-search input").value
      );
      window.location.pathname = cgpShortcodesRedirectSearchPath;
    });
  });
})(jQuery);
