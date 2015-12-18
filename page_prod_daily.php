<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
		  	<div class="panel-body">
				<div class="form-inline">
				  	<div class="form-group">
						<div class="col-xs-4">
							<input type="text" class="form-control" id="start" placeholder="Date From">
						</div>
				  	</div>
					<div class="form-group">
						<div class="col-xs-4">
							<input type="text" class="form-control" id="end" placeholder="Date End">
						</div>
					</div>
					<div class="form-group">
						<select class="form-control" id="level">
							<option value='region'>Region</option>
							<option value='branch'>Branch</option>
							<option value='cluster'>Cluster</option>
							<option value='kabupaten'>Kabupaten</option>
						</select>
					</div>
				  	<button type="submit" class="btn btn-default" onclick="prod_daily()">Generate</button>
				</div>
		  	</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-body">
            </div>
            <div class="panel-footer">
                <div id="traffic">

                </div>  
            </div>
            </div>
        
    </div>
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-body">
            </div>
            <div class="panel-footer">
                <div id="payload">

                </div>  
            </div>
            </div>
        
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-body">
            </div>
            <div class="panel-footer">
                <div id="revenue">

                </div>  
            </div>
            </div>
        
    </div>
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-body">
            </div>
            <div class="panel-footer">
                <div id="vlr">

                </div>  
            </div>
            </div>
        
    </div>
</div>



<script>

	prod_daily();
    function prod_daily(){
        var _level = $("#level").val();   
        var _start = $("#start").val(); 
        var _end = $("#end").val(); 
        var _total = _start + "," + _end + "," + _level;
        var loading = "<div align='center'><img src='assets/image/ajax-loader1.gif'/></div>";

        if (_start == '' && _end == '') 
        {
            prod_dily('traffic','Traffic',_level,'KErl','model/mod_prod_daily.php','','Erl',_total,_start,_end);
            prod_dily('payload','Payload',_level,'Gbyte','model/mod_prod_daily.php','','Erl',_total,_start,_end);
            prod_dily('revenue','Revenue',_level,'Bio','model/mod_prod_daily.php','','',_total,_start,_end);
            prod_dily('vlr','Vlr',_level,'','model/mod_prod_daily.php','','Erl',_total,_start,_end);
        }
        else
        {
            $('#traffic').html(loading);
            $('#payload').html(loading);
            $('#revenue').html(loading);
            $('#vlr').html(loading);
            prod_dily('traffic','Traffic',_level,'KErl','model/mod_prodDailyRange.php','','Erl',_total,_start,_end);
            prod_dily('payload','Payload',_level,'Gbyte','model/mod_prodDailyRange.php','','Erl',_total,_start,_end);
            prod_dily('revenue','Revenue',_level,'Bio','model/mod_prodDailyRange.php','','',_total,_start,_end);
            prod_dily('vlr','Vlr',_level,'','model/mod_prodDailyRange.php','','Erl',_total,_start,_end);
        }
    }

    function prod_dily(_toID,_title,_subTitle,_yAxis,_source,_sitename_relokasi,_satuan,_total,_start,_end) {
        var options = {
                chart: {
                        renderTo: _toID,
                        type: 'line',
                        zoomType: 'xy',
                        style: {
                                fontFamily: 'Source Sans Pro',
                                fontSize: '18px'
                        }					
                },
                plotOptions: {
                    line: {
                        marker: {
                            enabled: false
                        }
                    }
                },            
                title: {
                        text: _title,
                        x: -20 //center
                },
                subtitle: {
                        text: _subTitle,
                        x: -20
                },
                credits: {
                        enabled: false
                },
                xAxis: {					
                        categories: [],
                        type: 'datetime',										
                        // one week
                        //minRange: 14 * 24 * 3600000, // fourteen days
                        labels: {
                                        rotation: -90,
                                        y:30,		
                                        align: 'right',
                                        style: {
                                                //width: '100px'
                                        },
                                        formatter: function() {

                                                return (this.value);

                                        }					
                        },
                        tickInterval: 10
                },
                yAxis: {
                        title: {
                                text: _yAxis
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                        }]
                },
                legend: {  
                		width: 450,
						itemWidth: 100,
		                itemStyle: {
		                fontSize:'7px',
		                font: '7pt Source Sans Pro, Source Sans Pro, Source Sans Pro',
		                color: '#000000'
		              	}
                },
                series: []
        }

        $.getJSON(_source,{toID:_toID,total:_total,start:_start,end:_end}, function(json) {

                var len = json.length
                for(i=0;i<len;i++){
                    if(i===0){
                        options.xAxis.categories = json[i]['data'];
                    }else{
                        j = i-1;
                        options.series[j] = json[i];
                    }
                }            
                chart = new Highcharts.Chart(options);
        });  
    };

</script>
