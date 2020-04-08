var insights = require("./components/insights.js");
var Onboarding = require("./components/onboarding.js");

var helpieWidgets = require("./elements/widgets.js");
require("./components/update.js");

jQuery(document).ready(function () {
    console.log("KB Admin App Init !");

    // Components
    insights.init();
    Onboarding.init();


    // Elements
    helpieWidgets.init();
});

// Importing KB-Admin-App Stylesheet
import "../../css/admin/helpie-admin.scss";
