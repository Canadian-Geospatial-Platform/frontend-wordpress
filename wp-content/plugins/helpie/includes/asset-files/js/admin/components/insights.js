// (function($) {
//     'use strict';

/* Object: passwordProtectSettings */
var insights = {
	init: function() {
		if (window.location.search.indexOf("pauple-insights") !== (-1 || false)) {
			this.initChart();
			this.eventHandlers();
		}
	},

	initChart: function() {
		var thisModule = this;
		var nonce = helpieInsightsNonce;
		// Chart start
		var data = {
			action: "insights",
			nonce: nonce
		};

		var votesArray = [];

		jQuery.post(my_ajax_object.ajax_url, data, function(response) {
			var ajaxResponse = JSON.parse(response);
			votesArray = ajaxResponse;
			//
			//

			var happiness_score = thisModule.getHappinessScore(votesArray);
			//

			Chart.pluginService.register({
				beforeDraw: function(chart) {
					var width = chart.chart.width,
						height = chart.chart.height,
						ctx = chart.chart.ctx;

					ctx.restore();
					var fontSize = (height / 114).toFixed(2);
					ctx.font = "bold 24px Helvetica, Arial, sans-serif";
					ctx.fillStyle = "black";
					ctx.textBaseline = "middle";

					var text = happiness_score,
						textX = Math.round((width - ctx.measureText(text).width) / 2),
						textY = height / 2 - 12;

					ctx.fillText(text, textX, textY);

					// ctx.font = "29px FontAwesome";
					ctx.font = "400 12px Helvetica, Arial, sans-serif";

					var text = "Happiness Score",
						textX = Math.round((width - ctx.measureText(text).width) / 2),
						textY = height / 2 + 15;

					ctx.fillText(text, textX, textY);

					ctx.save();
				}
			});

			if (document.getElementById("myChart")) {
				var ctx = document.getElementById("myChart").getContext("2d");

				var data = thisModule.getChartData(votesArray);

				var options = thisModule.getChartOptions();

				var myChart = new Chart(ctx, {
					type: "doughnut",
					data: data,
					options: options
				}); // End of chart
			}
		});
	},

	getChartData: function(votesArray) {
		var data = {
			// labels: ['\uf004', '\uf118', '\uf11a', '\uf119'],
			labels: ["heart", "smile", "meh", "frown"],
			datasets: [
				{
					label: "# of Votes",
					data: [
						votesArray["heart"],
						votesArray["smile"],
						votesArray["meh"],
						votesArray["frown"]
					],
					backgroundColor: [
						"rgba(216,  105, 131, 1)",
						"rgba(186,  239,    175, 1)",
						"rgba(247,  220,    165,     1)",
						"rgba(232,  134, 131,    1)"
					],
					borderWidth: 1,
					// Boolean - whether or not the chart should be responsive and resize when the browser does.

					responsive: true,

					// Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container

					maintainAspectRatio: false
				}
			]
		};

		return data;
	},

	getChartOptions: function() {
		var options = {
			inGraphDataShow: true,
			startAngle: -180,
			inGraphDataTmpl: "<%=v2+' %'%>",
			percentageInnerCutout: 90,
			inGraphDataFontSize: 25,
			inGraphDataFontColor: "rgba(216,    105, 131, 1)",
			legend: {
				display: false,
				labels: {
					fontFamily: "FontAwesome"
				},
				showLabel: true //Enables labels on the pie
			}
		};

		return options;
	},

	getTotalVotes: function(votesArray) {
		var totalVotes = 0;
		for (var key in votesArray) {
			totalVotes += votesArray[key];
		}
		return totalVotes;
	},

	getHappinessScore: function(votesArray) {
		var thisModule = this;

		var totalVotes = thisModule.getTotalVotes(votesArray);
		//
		var maxHappiness = totalVotes * 3;
		var emotion_value = {
			heart: 3,
			smile: 1,
			meh: -1,
			frown: -2
		};

		var happiness_index = 0;

		for (var key in votesArray) {
			//
			happiness_index += votesArray[key] * emotion_value[key];
			//
		}

		var happiness_score = (happiness_index / maxHappiness) * 10;
		var happiness_score = Math.round(happiness_score * 100) / 100;
		return happiness_score;
	},

	eventHandlers: function() {
		jQuery(".key-posts-nav li a").click(function() {
			//
			jQuery(".post-list-section").hide();
			jQuery(".key-posts-nav li").removeClass("active");
			var target = jQuery(this).attr("data-target");
			jQuery(target).show();
			jQuery(this)
				.parent("li")
				.addClass("active");
		});

		jQuery(".key-users-nav li a").click(function() {
			//
			jQuery(".user-list-section").hide();
			jQuery(".key-users-nav li").removeClass("active");
			var target = jQuery(this).attr("data-target");
			jQuery(target).show();
			jQuery(this)
				.parent("li")
				.addClass("active");
		});
	}
};

module.exports = insights;

//     jQuery(document).ready(function() {
//         insights.init();
//     });

// })(jQuery);
