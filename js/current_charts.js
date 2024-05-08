jQuery(document).ready(function() {
    
    function showTooltip(x, y, contents) {
		jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
		  position: 'absolute',
		  display: 'none',
		  top: y + 5,
		  left: x + 5
		}).appendTo("body").fadeIn(200);
	 }
  
    
    /***** USING OTHER SYMBOLS *****/
    
    var firefox = [[0, 5], [1, 8], [2,6], [3, 11], [4, 7], [5, 13], [6, 9], [7,8], [8,10], [9,9],[10,13]];
	 //var chrome = [[0, 3], [1, 6], [2,4], [3, 9], [4, 5], [5, 11], [6, 7], [7,6], [8,8], [9,7],[10,11]];
	
	 var plot2 = jQuery.plot(jQuery("#basicflot2"),
		[ { data: firefox,
          label: "Firefox",
          color: "#D9534F",
          points: {
            symbol: "square"
          }
        }
      ],
      {
		  series: {
			 lines: {
            show: true,
            lineWidth: 2
          },
			 points: {
            show: true
          },
          shadowSize: 0
		  },
		  legend: {
          position: 'nw'
        },
		  grid: {
          hoverable: true,
          clickable: true,
          borderColor: '#ddd',
          borderWidth: 1,
          labelMargin: 10,
          backgroundColor: '#fff'
        },
		  yaxis: {
          min: 0,
          max: 15,
          color: '#eee'
        },
        xaxis: {
          color: '#eee',
          max: 12
		 
        }
		});
		
	 var previousPoint2 = null;
	 jQuery("#basicflot2").bind("plothover", function (event, pos, item) {
      jQuery("#x").text(pos.x.toFixed(2));
      jQuery("#y").text(pos.y.toFixed(2));
			
		if(item) {
		  if (previousPoint2 != item.dataIndex) {
			 previousPoint2 = item.dataIndex;
						
			 jQuery("#tooltip").remove();
			 var x = item.datapoint[0].toFixed(2),
			 y = item.datapoint[1].toFixed(2);
	 			
			 showTooltip(item.pageX, item.pageY,
				  item.series.label + " of " + x + " = " + y);
		  }
			
		} else {
		  jQuery("#tooltip").remove();
		  previousPoint2 = null;            
		}
		
	 });
		
	 jQuery("#basicflot2").bind("plotclick", function (event, pos, item) {
		if (item) {
		  plot2.highlight(item.series, item.datapoint);
		}
	 });
    
    
 
   
    
    /***** BAR CHART *****/
    
    var bardata = [ ["Jan", 100], ["Feb", 23], ["Mar", 18], ["Apr", 13], ["May", 17], ["Jun", 30], ["Jul", 26], ["Aug", 16], ["Sep", 17], ["Oct", 5], ["Nov", 8], ["Dec", 15] ];

	 jQuery.plot("#barchart", [ bardata ], {
		  series: {
            lines: {
              lineWidth: 1  
            },
				bars: {
					show: true,
					barWidth: 0.5,
					align: "center",
               lineWidth: 0,
               fillColor: "#428BCA"
				}
		  },
        grid: {
            borderColor: '#ddd',
            borderWidth: 1,
            labelMargin: 10
		  },
		  xaxis: {
				mode: "categories",
				tickLength: 0
		  }
	 });
    
    
   
   /***** MORRIS CHARTS *****/
  
    new Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'bar-chart',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: [
            { y: 'Jan', a: 30, b: 20 },
            { y: 'Feb', a: 75,  b: 65 },
            { y: 'Mar', a: 50,  b: 40 },
            { y: 'Apr', a: 75,  b: 65 },
            { y: 'May', a: 50,  b: 40 },
            { y: 'Jun', a: 75,  b: 65 },
            { y: 'Jul', a: 100, b: 90 }
        ],
		
		/*data: [
            { y: '2006', a: 30, b: 20 },
            { y: '2007', a: 75,  b: 65 },
            { y: '2008', a: 50,  b: 40 },
            { y: '2009', a: 75,  b: 65 },
            { y: '2010', a: 50,  b: 40 },
            { y: '2011', a: 75,  b: 65 },
            { y: '2012', a: 100, b: 90 }
        ],*/
        xkey: 'y',
        ykeys: ['a', 'b'],
        //labels: ['Series A', 'Series B'],
		labels: ['EB A', 'GEN B'],
        lineWidth: '1px',
        fillOpacity: 0.8,
        smooth: false,
        hideHover: true
    });
    
    new Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'stacked-chart',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: [
            { y: '2006', a: 30, b: 20 },
            { y: '2007', a: 75,  b: 65 },
            { y: '2008', a: 50,  b: 40 },
            { y: '2009', a: 75,  b: 65 },
            { y: '2010', a: 50,  b: 40 },
            { y: '2011', a: 75,  b: 65 },
            { y: '2012', a: 100, b: 90 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        barColors: ['#1CAF9A', '#428BCA'],
        lineWidth: '1px',
        fillOpacity: 0.8,
        smooth: false,
        stacked: true,
        hideHover: true
    });
    
    new Morris.Donut({
        element: 'donut-chart',
        data: [
          {label: "Download Sales", value: 12},
          {label: "In-Store Sales", value: 30},
          {label: "Mail-Order Sales", value: 20}
        ]
    });
    
    new Morris.Donut({
        element: 'donut-chart2',
        data: [
          {label: "Chrome", value: 30},
          {label: "Firefox", value: 20},
          {label: "Opera", value: 20},
          {label: "Safari", value: 20},
          {label: "Internet Explorer", value: 10}
        ],
        colors: ['#D9534F','#1CAF9A','#428BCA','#5BC0DE','#428BCA']
    });

  

  
});