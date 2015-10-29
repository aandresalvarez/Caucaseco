
        
        // Loading Google Visualization API Reference
        google.load( 'visualization', '1', { packages:['corechart'] });


        // Creating chart as marker
        function ChartMarker( options ) {
            this.setValues( options );
            
            this.$inner = $('<div>').css({
                position: 'relative',
                left: '-50%', top: '-50%',
                width: options.width,
                height: options.height,
                fontSize: '1px',
                lineHeight: '1px',
                backgroundColor: 'transparent',
                cursor: 'default'
            });

            this.$div = $('<div>')
                .append( this.$inner )
                .css({
                    position: 'absolute',
                    display: 'none'
                });
        };

        ChartMarker.prototype = new google.maps.OverlayView;

        ChartMarker.prototype.onAdd = function() {
            $( this.getPanes().overlayMouseTarget ).append( this.$div );
        };

        ChartMarker.prototype.onRemove = function() {
            this.$div.remove();
        };

        ChartMarker.prototype.draw = function() {
            var marker = this;
            var projection = this.getProjection();
            var position = projection.fromLatLngToDivPixel( this.get('position') );

            this.$div.css({
                left: position.x,
                top: position.y,
                display: 'block'
            })

            this.$inner
                .html( '<img src="' + this.get('image') + '"/>' )
                .click( function( event ) {
                    var events = marker.get('events');
                    events && events.click( event );
                });
                
            this.chart = new google.visualization.PieChart( this.$inner[0] );
            this.chart.draw( this.get('chartData'), this.get('chartOptions') );
        };
        
        // Initializing map with data for pie chart

        function initialize() {
            var latLng = new google.maps.LatLng(19.102351,72.873473);

            var map = new google.maps.Map( $('#map_canvas')[0], {
                zoom: 11,
                center: latLng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            
            var data = google.visualization.arrayToDataTable([
                [ 'Task', 'Hours per Day' ],
                [ 'Work', 11 ],
                [ 'Eat', 2 ],
                [ 'Commute', 2 ],
                [ 'Watch TV', 2 ],
                [ 'Sleep', 7 ]
            ]);
            
            var options = {
                fontSize: 11,
                backgroundColor: 'transparent',
                legend: 'none'
            };
            
            var marker = new ChartMarker({
                map: map,
                position: latLng,
                width: '100px',
                height: '100px',
                chartData: data,
                chartOptions: options,
                events: {
                    click: function( event ) {
                        alert( 'Latitude: ' + marker.position.hb + 'and Longitude: ' + marker.position.ib ); //Clicked marker lat lng
                    }
                }
            });
        };

        $( initialize );