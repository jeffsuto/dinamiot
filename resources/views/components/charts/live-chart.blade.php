<div class="height-{{ @$height }}">
    <div id="live-chart-{{ $component->id }}" style="width:100%; height:100%"></div>
</div>

@push('script')
    <script>
        am4core.useTheme(am4themes_dark);
        
        // Create chart
        var chart{{ $component->id }} = am4core.create("live-chart-{{ $component->id }}", am4charts.XYChart);
        
        $.ajax({
            url: '{{ route("api.v1.datasets.live-chart") }}',
            data: {
                id: "{{ $component->id }}"
            }
        }).done(function(data){
            chart{{ $component->id }}.data = data;
        });
    
        var dateAxis = chart{{ $component->id }}.xAxes.push(new am4charts.DateAxis());
        dateAxis.periodChangeDateFormats.setKey("second", "[bold]h:mm a");
        dateAxis.periodChangeDateFormats.setKey("minute", "[bold]h:mm a");
        dateAxis.periodChangeDateFormats.setKey("hour", "[bold]h:mm a");
        dateAxis.tooltipDateFormat = "HH:mm:ss, d MMMM";
    
        var valueAxis = chart{{ $component->id }}.yAxes.push(new am4charts.ValueAxis());
        valueAxis.tooltip.disabled = true;
        valueAxis.title.text = "{{ $component->name }}";
    
        var series = chart{{ $component->id }}.series.push(new am4charts.LineSeries());
        series.dataFields.dateX = "date";
        series.dataFields.valueY = "value";
        series.tooltipText = "{{ $component->name }}: [bold]{valueY}[/]";
        series.fillOpacity = 0.3;
    
        chart{{ $component->id }}.cursor = new am4charts.XYCursor();
        chart{{ $component->id }}.cursor.lineY.opacity = 0;
        chart{{ $component->id }}.scrollbarX = new am4charts.XYChartScrollbar();
        chart{{ $component->id }}.scrollbarX.series.push(series);
    
        dateAxis.start = 0.8;
        dateAxis.keepSelection = true;
        
        // add new chart data
        socket.on('value', function(data){
            if (data.data.type == "analog" && data.data.component_id == '{!! $component->id !!}') {
                chart{{ $component->id }}.addData(data.data);
            }
        });
    </script>
@endpush