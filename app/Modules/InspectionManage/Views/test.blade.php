<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>A simple, clean, and responsive HTML invoice template</title>

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: #777;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}
		</style>
	</head>

	<body>
		<table style="width: 100%">
			<tr>
				<td style="text-align: left;">
					<img src="{{url('storage/image/sis.png')}}" alt="Company logo" style="width: 100px;"/>
				</td>
				<td style="text-align: right">
					<h1 style="color: #488f3a">Inspection Report</h1>
				</td>
			</tr>
		</table>

		<table style="width: 100%">
			<tr>
				<td style="text-align: left;">
					<h2 style="color: #000">Overview</h2>
				</td>
			</tr>
			<tr>
				<td style="text-align: left;">
					<hr>
				</td>
			</tr>
		</table>

		<table style="width: 100%" style="background-color: #c5e1a4;padding: 10px;border-radius: 10px;">
			<tr>
				<td style="text-align: left;">
					<h4 style="color: #488f3a">Overall Score: {{$data->scored_points ? $data->scored_points:0}} / {{$data->total_points}} ({{$data->percentage ? $data->percentage:0.00}}%)</h4>
				</td>
				<td style="text-align: right;">
					<h4 style="color: #488f3a">Rating: {{$data->rating? $data->rating: 'Not Rated'}}</h4>
				</td>
			</tr>
		</table>
		

		<table style="width: 100%;padding-top: 20px">
			<tr>
				<td style="text-align: left;">
					<table style="width: 100%;">
						<tr>
							<td style="color: #00000066">Client</td>
						</tr>
						<tr>
							<td><strong style="color: #444444">{{$data['job']['client']->first_name}} {{$data['job']['client']->last_name}} - {{$data['job']['client']->phone}}</strong></td>
						</tr>
					</table>
					<div style="height: 3px"></div>
					<table style="width: 100%;">
						<tr>
							<td style="color: #00000066">Location Address</td>
						</tr>
						<tr>
							<td><strong style="color: #444444">{{$data['job']['client']->address}}</strong></td>
						</tr>
					</table>
					<div style="height: 3px"></div>
					<table style="width: 100%;">
						<tr>
							<td style="color: #00000066">Inspection Manager</td>
						</tr>
						<tr>
							<td><strong style="color: #444444">{{$data['manager']->first_name}} {{$data['manager']->last_name}}</strong></td>
						</tr>
					</table>
					<div style="height: 3px"></div>
					<table style="width: 100%;">
						<tr>
							<td style="color: #00000066">Inspection Date</td>
						</tr>
						<tr>
							<td><strong style="color: #444444">{{$data->inspection_date}}</strong></td>
						</tr>
					</table>
				</td>
				<td style="text-align: right">
					<img src="{{$encoded_url}}">
				</td>
			</tr>
		</table>

		@foreach($data['sections'] as $key=> $section)
		<table style="width: 100%;padding-top: 20px">
			<tr>
				<td style="text-align: left;">
					<h3 style="color: #488f3a">{{$key+1}}. {{$section['jobSection']->name}}</h3>
				</td>
				<td style="text-align: right;">
					<h3 style="color: #488f3a">
						{{$section->scored_points ? $section->scored_points:0}} / {{$section->total_score}} ({{$section->percentage ? $section->percentage:0}}%)
					</h3>
				</td>
			</tr>

			@foreach($section['tasks'] as $_key=> $task)
			<tr>
				<td style="width: 100%">
					<table style="width: 100%">
						<tr>
							<td style="text-align: left;width: 70%;">
								<h5 style="color: #000">{{$key+1}}.{{$_key+1}}. {{$task->title}}</h5>
							</td>
							<td style="text-align: right;width: 30%;">
								<h5 style="color: #000">{{$task->scored_points?$task->scored_points:0}} / 10</h5>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="height: 3px"></td>
						</tr>

						<tr>
							<td style="width: 4%;"></td>
							<td style="text-align: left;font-size: small;color: #00000066;">Note by inspection officer</td>
						</tr>
						<tr>
							<td style="width: 4%;"></td>
							<td style="text-align: left;font-size: small;color: #000">{{$task->note}}</td>
						</tr>

						@if($data['job']->job_type_id==1)
						<tr>
							<td style="width: 4%"></td>
							<td style="width: 48%;text-align: left;">
								<span>Now</span>
							</td>
							<td style="width: 48%;text-align: left;">
								<span>Before</span>
							</td>
						</tr>
						<tr>
							<td style="width: 4%"></td>
							<td style="width: 48%;text-align: left;">
								<img src="{{url('storage')}}/{{$task->image}}" style="width: 100px;"/>
							</td>
							<td style="width: 48%;text-align: left;">
								<img src="{{url('storage')}}/{{$task['task']->image}}" style="width: 100px;"/>
							</td>
						</tr>
						@endif

						@if($data['job']->job_type_id==2)
						<tr>
							<td style="width: 4%"></td>
							<td style="width: 60%;text-align: left;">
								
							</td>
							<td style="width: 36%;text-align: left;">
								
							</td>
						</tr>
						<tr>
							<td style="width: 4%"></td>
							<td style="width: 60%;text-align: left;">
								<img src="{{url('storage')}}/{{$task->image}}" style="width: 100px;"/>
							</td>
							<td style="width: 36%;text-align: left;">
								
							</td>
						</tr>
						@endif
					</table>
				</td>
			</tr>
			@endforeach

		</table>
		@endforeach

		
		<div style="page-break-after: always;"></div>

		<!-- <table style="width: 100%">
			<tr>
				<td style="text-align: left;">
					<h2 style="color: #000">Summery</h2>
				</td>
			</tr>
			<tr>
				<td style="text-align: left;">
					<hr>
				</td>
			</tr>
		</table>

		<table style="width: 100%">
			<tr>
				<td style="text-align: left;">
					<h1 style="color: #488f3a;font-weight: bolder;">Hazard and Risk Review</h1>
				</td>
			</tr>
			<tr>
				<td style="height: 10px;">
					
				</td>
			</tr>
			<tr>
				<td style="text-align: left;">
					No Hazard Report exists. A new Hazard and Risk Assessment has been scheduled.
				</td>
			</tr>
		</table>

		<table style="width: 100%">
			<tr>
				<td style="height: 20px;">
					
				</td>
			</tr>
		</table> -->

		<table style="width: 100%">
			<tr>
				<td style="text-align: left;">
					<h1 style="color: #488f3a;font-weight: bolder;">Inspector Comments</h1>
				</td>
			</tr>
			<tr>
				<td style="height: 10px;">
					
				</td>
			</tr>
			<tr>
				<td style="text-align: left;">
					<!-- Site presenting well. At the time of the inspection all areas were looking up to standard. A little more attention to the hall windows seals. -->
				</td>
			</tr>
		</table>

		<table style="width: 100%">
			<tr>
				<td style="height: 60px;">
					
				</td>
			</tr>
		</table>

		<table style="width: 100%">
			<tr>
				<td style="text-align: left;">
					<h1 style="color: #488f3a;font-weight: bolder;">Criteria Score Definitions</h1>
				</td>
				<td style="text-align: right">
					<h1 style="color: #488f3a;font-weight: bolder;">Report Rating Definitions</h1>
				</td>
			</tr>

			<tr>
				<td style="width: 50%">
					<table style="width: 100%">
						<tr>
							<td style="height: 20px;">
								
							</td>
						</tr>
					</table>
					<table style="width: 100%;text-align: left;">
						<tr>
							<td style="width: 20%"><h3 style="color: navy">Score</h3></td>
							<td style="width: 80%"><h3 style="color: navy">Definition</h3></td>
						</tr>

						<tr>
							<td style="color: #000;text-align: center;font-size: small;">
								<div style="height: 0.5px"></div>
								10
								
							</td>
							<td style="color: #444;font-size: small;">
								<div style="height: 0.5px"></div>
								Task Complete / Met Scope
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: center;font-size: small;">
								<div style="height: 0.5px"></div>
								9
								
							</td>
							<td style="color: #444;font-size: small;">
								<div style="height: 0.5px"></div>
								Task Complete with Minor Deviations
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: center;font-size: small;">
								<div style="height: 0.5px"></div>
								8
								
							</td>
							<td style="color: #444;font-size: small;">
								<div style="height: 0.5px"></div>
								Task Complete with Moderate Deviations
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: center;font-size: small;">
								<div style="height: 0.5px"></div>
								7
								
							</td>
							<td style="color: #444;font-size: small;">
								<div style="height: 0.5px"></div>
								Task Performed with Consistent Deviations 6 Task Attempted with Major Deviations
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: center;font-size: small;">
								<div style="height: 0.5px"></div>
								5
								
							</td>
							<td style="color: #444;font-size: small;">
								<div style="height: 0.5px"></div>
								Incomplete - Improvement Required
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: center;font-size: small;">
								<div style="height: 0.5px"></div>
								4
								
							</td>
							<td style="color: #444;font-size: small;">
								<div style="height: 0.5px"></div>
								Incomplete - Immediate Attention Required 3 Incomplete - Recent Repeat Issue
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: center;font-size: small;">
								<div style="height: 0.5px"></div>
								2
								
							</td>
							<td style="color: #444;font-size: small;">
								<div style="height: 0.5px"></div>
								Incomplete - Ongoing Repeat Issue
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: center;font-size: small;">
								<div style="height: 0.5px"></div>
								1
								
							</td>
							<td style="color: #444;font-size: small;">
								<div style="height: 0.5px"></div>
								No Attempt when Last Scheduled
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: center;font-size: small;">
								<div style="height: 0.5px"></div>
								0
								
							</td>
							<td style="color: #444;font-size: small;">
								<div style="height: 0.5px"></div>
								No Attempt on Consecutive Occasions
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: center;font-size: small;">
								<div style="height: 0.5px"></div>
								N/A
								
							</td>
							<td style="color: #444;font-size: small;">
								<div style="height: 0.5px"></div>
								Not Applicable
								
							</td>
						</tr>

					</table>
				</td>
				<td style="width: 50%">
					<table style="width: 100%">
						<tr>
							<td style="height: 20px;">
								
							</td>
						</tr>
					</table>
					<table style="width: 100%;text-align: left;">
						<tr>
							<td style="width: 60%;text-align:right"><h3 style="color: navy">Rating</h3></td>
							<td style="width: 40%;text-align: right;"><h3 style="color: navy">Definition</h3></td>
						</tr>

						<tr>
							<td style="color: #000;text-align: right;font-size: small;">
								<div style="height: 0.5px"></div>
								>= 95%
								
							</td>
							<td style="color: #444;font-size: small;text-align: right;">
								<div style="height: 0.5px"></div>
								Excellent
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: right;font-size: small;">
								<div style="height: 0.5px"></div>
								>= 90%
								
							</td>
							<td style="color: #444;font-size: small;text-align: right;">
								<div style="height: 0.5px"></div>
								Very Good
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: right;font-size: small;">
								<div style="height: 0.5px"></div>
								>= 85%
								
							</td>
							<td style="color: #444;font-size: small;text-align: right;">
								<div style="height: 0.5px"></div>
								Good
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: right;font-size: small;">
								<div style="height: 0.5px"></div>
								>= 70%
								
							</td>
							<td style="color: #444;font-size: small;text-align: right;">
								<div style="height: 0.5px"></div>
								Below Average
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: right;font-size: small;">
								<div style="height: 0.5px"></div>
								>= 40%
								
							</td>
							<td style="color: #444;font-size: small;text-align: right;">
								<div style="height: 0.5px"></div>
								Unsatisfactory
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: right;font-size: small;">
								<div style="height: 0.5px"></div>
								> 0%
								
							</td>
							<td style="color: #444;font-size: small;text-align: right;">
								<div style="height: 0.5px"></div>
								Incomplete
								
							</td>
						</tr>
						<tr>
							<td style="color: #000;text-align: right;font-size: small;">
								<div style="height: 0.5px"></div>
								0%
								
							</td>
							<td style="color: #444;font-size: small;text-align: right;">
								<div style="height: 0.5px"></div>
								Not Applicable
								
							</td>
						</tr>

					</table>
				</td>
			</tr>
		</table>

	</body>
</html>