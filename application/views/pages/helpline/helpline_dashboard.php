	<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css"></script>
	
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/highcharts.js"></script>

	<style>
		.panel-body { padding-top:0px; }
	</style>
	
	<?php 
		$total=0;
		foreach($hospital_report as $h){
			$total+=$h->count;
		}
		$d_array = array();
		$default_time = strtotime("00:00:00");
		foreach($duration as $d){
			$d_array[]= strtotime($d->dial_call_duration)-$default_time;
		}
		$average = calculate_average($d_array);
		$median = calculate_median($d_array);
	?>
	<script>
	$(function(){
		$(".date").datetimepicker({
			format : "D-MMM-YYYY"
		});
	
	Highcharts.chart('hospitalChart', {
		chart : {type:'bar'},
		title: false,
		xAxis: {
			categories: [<?php $i=1;foreach($hospital_report as $a) { echo "'".$a->hospital;if($i<count($hospital_report)) echo "' ,"; else echo "'"; $i++; }?>],
		},
		yAxis: {
			min: 0, title: { text: 'Calls', align: 'high' }, labels: { overflow: 'justify' }
		},
		plotOptions: {bar: { dataLabels: { enabled: true } } },
		legend: {enabled:false},
		credits: {enabled:false},
		series: [{ name: 'Calls', colorByPoint: true,
			data: [<?php $i=1;foreach($hospital_report as $a) { echo $a->count;if($i<count($hospital_report)) echo " ,"; $i++; }?>]
		}]
	});
	
	Highcharts.chart('volunteerChart', {
		chart : {type:'bar'},
		title: false,
		xAxis: {
			categories: [<?php $i=1;foreach($volunteer_report as $a) { echo "'".$a->dial_whom_number;if($i<count($volunteer_report)) echo "' ,"; else echo "'"; $i++; }?>],
		},
		yAxis: {
			min: 0, title: { text: 'Calls', align: 'high' }, labels: { overflow: 'justify' }
		},
		plotOptions: {bar: { dataLabels: { enabled: true } } },
		legend: {enabled:false},
		credits: {enabled:false},
		series: [{ name: 'Calls', colorByPoint: true,
			data: [<?php $i=1;foreach($volunteer_report as $a) { echo $a->count;if($i<count($volunteer_report)) echo " ,"; $i++; }?>]
		}]
	});
	Highcharts.chart('durationChart', {
		chart : {type:'column'},
		title: false,
		xAxis: {
			categories: ['Average','Median'],
		},
		yAxis: {
			min: 0, title: { text: 'Time (in seconds)', align: 'high' }, labels: { overflow: 'justify' }
		},
		plotOptions: {bar: { dataLabels: { enabled: true } } },
		legend: {enabled:false},
		credits: {enabled:false},
		series: [{ name: 'Time', colorByPoint: true,
			data: [<?php echo $average;?>, <?php echo $median;?>]
		}]
	});
	
	
	var pie_chart = {
		plotBackgroundColor: null, 
		plotBorderWidth: null, 
		plotShadow: false, 
		type: 'pie'
	};
	var pie_credits = {enabled: false};
	var pie_tooltip = {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	};
	var pie_plotOptions= {
		pie: {
			allowPointSelect: true,
			cursor: 'pointer',
			showInLegend: true,
			dataLabels: {
				enabled: false,
				format: '<b>{point.name}</b>: {point.percentage:.1f} %',
				style: {
					color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
				},
				distance: 0
			}
		}
	};
	pie_legend= {
		align: 'left',
		layout: 'horizontal',
		verticalAlign: 'bottom',
		floating:false,
		itemDistance:10,
		y:10,
		reversed:true
	};
	
	Highcharts.chart('callCategory', {
		chart: pie_chart,
		credits: pie_credits,
		title: false,
		tooltip: pie_tooltip,
		plotOptions: pie_plotOptions,
		legend: pie_legend,
		series: [{
			name: 'Calls',
			colorByPoint: true,
			data: [<?php $i=1;foreach($call_category_report as $a) { echo "{ name: '$a->call_category', y: $a->count }"; if($i<count($call_category_report)) echo " ,"; $i++; }?>]
		}]
	});
	Highcharts.chart('callerType', {
		chart: pie_chart,
		credits: pie_credits,
		title: false,
		tooltip: pie_tooltip,
		plotOptions: pie_plotOptions,
		legend: pie_legend,
		series: [{
			name: 'Calls',
			colorByPoint: true,
			data: [<?php $i=1;foreach($caller_type_report as $a) { echo "{ name: '$a->caller_type', y: $a->count }"; if($i<count($caller_type_report)) echo " ,"; $i++; }?>]
		}]
	});
	Highcharts.chart('callType', {
		chart: pie_chart,
		credits: pie_credits,
		title: false,
		tooltip: pie_tooltip,
		plotOptions: pie_plotOptions,
		legend: pie_legend,
		series: [{
			name: 'Calls',
			colorByPoint: true,
			data: [<?php $i=1;foreach($call_type_report as $a) { echo "{ name: '$a->call_type', y: $a->count }"; if($i<count($call_type_report)) echo " ,"; $i++; }?>]
		}]
	});
	Highcharts.chart('op_ip', {
		chart: pie_chart,
		credits: pie_credits,
		title: false,
		tooltip: pie_tooltip,
		plotOptions: pie_plotOptions,
		legend: pie_legend,
		series: [{
			name: 'Calls',
			colorByPoint: true,
			data: [<?php $i=1;foreach($op_ip_report as $a) { echo "{ name: '$a->ip_op', y: $a->count }"; if($i<count($op_ip_report)) echo " ,"; $i++; }?>]
		}]
	});
	Highcharts.chart('to_number', {
		chart: pie_chart,
		credits: pie_credits,
		title: false,
		tooltip: pie_tooltip,
		plotOptions: pie_plotOptions,
		legend: pie_legend,
		series: [{
			name: 'Calls',
			colorByPoint: true,
			data: [<?php $i=1;foreach($to_number_report as $a) { echo "{ name: '$a->to_number', y: $a->count }"; if($i<count($to_number_report)) echo " ,"; $i++; }?>]
		}]
	});
	});
	</script>
	
			<?php 
			if($this->input->post('from_date')) $from_date = date("d-M-Y",strtotime($this->input->post('from_date'))); else $from_date = date("d-M-Y");
			if($this->input->post('to_date')) $to_date = date("d-M-Y",strtotime($this->input->post('to_date'))); else $to_date = date("d-M-Y");
			?>
			<div class="row">
			<?php echo form_open('dashboard/helpline/',array('role'=>'form','class'=>'form-custom')); ?>
			<div style="position:relative;display:inline;">
			<input type="text" class="date" name="from_date" class="form-control" value="<?php echo $from_date;?>" />
			</div>
			<div  style="position:relative;display:inline;">
			<input type="text" class="date" name="to_date" class="form-control" value="<?php echo $to_date;?>" />	
			</div>
			<select name="caller_type" style="width:100px" class="form-control">
				<option value="">Select</option>
				<?php foreach($caller_type as $ct){ ?>
					<option value="<?php echo $ct->caller_type_id;?>"
					<?php if($this->input->post('caller_type') == $ct->caller_type_id) echo " selected "; ?>
					><?php echo $ct->caller_type;?></option>
				<?php } ?>
			</select>	
			<select name="call_category" style="width:100px" class="form-control">
				<option value="">Select</option>
				<?php foreach($call_category as $cc){ ?>
					<option value="<?php echo $cc->call_category_id;?>"
					<?php if($this->input->post('call_category') == $cc->call_category_id) echo " selected "; ?>									
					><?php echo $cc->call_category;?></option>
				<?php } ?>
			</select>	
			<select name="resolution_status" style="width:100px" class="form-control">
				<option value="">Select</option>
				<?php foreach($resolution_status as $rs){ ?>
					<option value="<?php echo $rs->resolution_status_id;?>"
					<?php if($this->input->post('resolution_status') == $rs->resolution_status_id) echo " selected "; ?>																		
					><?php echo $rs->resolution_status;?></option>
				<?php } ?>
			</select>
			<select name="hospital" style="width:100px" class="form-control">
				<option value="">Select</option>
				<?php foreach($all_hospitals as $hosp){ ?>
					<option value="<?php echo $hosp->hospital_id;?>"
					<?php if($this->input->post('hospital') == $hosp->hospital_id) echo " selected "; ?>																		
					><?php echo $hosp->hospital;?></option>
				<?php } ?>
			</select>
			<select name="visit_type" style="width:100px" class="form-control">
				<option value="">Select</option>
					<option value="OP"
					<?php if($this->input->post('visit_type') == "OP") echo " selected "; ?>																		
					>OP</option>
					<option value="IP"
					<?php if($this->input->post('visit_type') == "IP") echo " selected "; ?>																		
					>IP</option>
			</select>	
			<input type="submit" name="submit" value="Go" class="btn btn-primary btn-sm" />
			</form>
			<hr>
		</div>
	
	
	<div class="row"> 		
		<div class="col-md-4">
			<div class="panel panel-default">
			<div class="panel panel-heading">
				<h4>Hospital</h4>
			</div>
			<div class="panel-body">
			<div id="hospitalChart" style="width:300px;height:250px"></div>
			</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
			<div class="panel panel-heading">
				<h4>Category</h4>
			</div>
			<div class="panel-body">
			<div id="callCategory" style="width:300px;height:250px"></div>
			</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
			<div class="panel panel-heading">
				<h4>Caller</h4>
			</div>
			<div class="panel-body">
			<div id="callerType" style="width:300px;height:250px"></div>
			</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
			<div class="panel panel-heading">
				<h4>Status</h4>
			</div>
			<div class="panel-body">
			<div id="callType" style="width:300px;height:250px"></div>
			</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
			<div class="panel panel-heading">
				<h4>Duration</h4>
			</div>
			<div class="panel-body">
			<div id="durationChart" style="width:300px;height:250px"></div>
			</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
			<div class="panel panel-heading">
				<h4>Patient Type</h4>
			</div>
			<div class="panel-body">
			<div id="op_ip" style="width:300px;height:250px"></div>
			</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
			<div class="panel panel-heading">
				<h4>Reciever</h4>
			</div>
			<div class="panel-body">
			<div id="volunteerChart" style="width:300px;height:250px"></div>
			</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
			<div class="panel panel-heading">
				<h4>Helpline</h4>
			</div>
			<div class="panel-body">
			<div id="to_number" style="width:300px;height:250px"></div>
			</div>
			</div>
		</div>
	</div>

	
	
	
<?php 
function calculate_median($arr) {
    $count = count($arr); //total numbers in array
    $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
    if($count % 2) { // odd number, middle is the median
        $median = $arr[$middleval];
    } else { // even number, calculate avg of 2 medians
        $low = $arr[$middleval];
        $high = $arr[$middleval+1];
        $median = (($low+$high)/2);
    }
    return $median;
}

function calculate_average($arr) {
	$total = 0;
    $count = count($arr); //total numbers in array
    foreach ($arr as $value) {
        $total = $total + $value; // total value of array numbers
    }
    $average = ($total/$count); // get average value
    return $average;
}
?>