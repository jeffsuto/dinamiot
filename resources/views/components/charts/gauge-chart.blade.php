<div id="gauge-chart-{{ $component->id }}" style="width:100%; height:100%; margin-top:10px"></div>

@push('script')
    <script>
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // create chart
        var chartGauge{{ $component->id }} = am4core.create("gauge-chart-{{ $component->id }}", am4charts.GaugeChart);
        chartGauge{{ $component->id }}.hiddenState.properties.opacity = 0; // this makes initial fade in effect

        chartGauge{{ $component->id }}.innerRadius = -40;
        
        var axis{{ $component->id }} = chartGauge{{ $component->id }}.xAxes.push(new am4charts.ValueAxis());
        axis{{ $component->id }}.min = {{ $component->min_value }};
        axis{{ $component->id }}.max = {{ $component->max_value }};
        axis{{ $component->id }}.strictMinMax = true;
        axis{{ $component->id }}.renderer.grid.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        axis{{ $component->id }}.renderer.grid.template.strokeOpacity = 0.3;

        var colorSet = new am4core.ColorSet();

        var range0 = axis{{ $component->id }}.axisRanges.create();
        range0.value = axis{{ $component->id }}.min;
        range0.endValue = Math.floor(axis{{ $component->id }}.min+(axis{{ $component->id }}.max-axis{{ $component->id }}.min)*50/100);
        range0.axisFill.fillOpacity = 1;
        range0.axisFill.fill = colorSet.getIndex(0);
        range0.axisFill.zIndex = - 1;

        var range1 = axis{{ $component->id }}.axisRanges.create();
        range1.value = range0.endValue;
        range1.endValue = Math.floor(range0.endValue+(axis{{ $component->id }}.max-range0.endValue)*60/100);
        range1.axisFill.fillOpacity = 1;
        range1.axisFill.fill = colorSet.getIndex(2);
        range1.axisFill.zIndex = -1;

        var range2 = axis{{ $component->id }}.axisRanges.create();
        range2.value = range1.endValue;
        range2.endValue = axis{{ $component->id }}.max;
        range2.axisFill.fillOpacity = 1;
        range2.axisFill.fill = colorSet.getIndex(4);
        range2.axisFill.zIndex = -1;

        var hand{{ $component->id }} = chartGauge{{ $component->id }}.hands.push(new am4charts.ClockHand());

        var current_value = {!! (!empty($component->value) ? $component->value:0.0) !!};
        if (current_value > axis{{ $component->id }}.max) {
            current_value = axis{{ $component->id }}.max;
        } else if (current_value < axis{{ $component->id }}.min) {
            current_value = axis{{ $component->id }}.min;
        } else {
            current_value = {!! (!empty($component->value) ? $component->value:0.0) !!};
        }

        var animation = new am4core.Animation(hand{{ $component->id }}, {
            property: "value",
            to: current_value
        }, 1000, am4core.ease.cubicOut).start();

        // update gauge chart data
        socket.on('value', function(data){
            if (data.data.type == "analog" && data.data.component_id == '{!! $component->id !!}') {
                var value = data.data.value;
            
                if (value < axis{{ $component->id }}.min) {
                    value = axis{{ $component->id }}.min
                } else if (value > axis{{ $component->id }}.max){
                    value = axis{{ $component->id }}.max
                }

                var animation = new am4core.Animation(hand{{ $component->id }}, {
                    property: "value",
                    to: value
                }, 1000, am4core.ease.cubicOut).start()
            }
        });
    </script>
@endpush