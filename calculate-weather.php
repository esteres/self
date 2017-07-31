<?php
mb_internal_encoding('UTF-8');

mb_http_output('UTF-8');



header('Content-Type: text/html; charset=UTF-8');
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Weather Calculate</title>
		<link rel="stylesheet" href="css/jquery-ui.min.css" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/main.css" />
		<script src="js/jquery-3.2.1.min.js"></script>	
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/main.js"></script>
    </head>
    <body>
		<div class="container">
			<div class="row vertical-offset-100">
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">  
							<h1 class="panel-title">
								<span class="glyphicon glyphicon-cloud"></span> Current weather in your city</h1>
						</div>
						<div class="panel-body">
							<form class="form-inline">
							  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<label class="sr-only" for="inlineFormInput">Country</label>
								<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="country" name="country" placeholder="Enter country">
							  </div>
							  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<label class="sr-only" for="inlineFormInputGroup">City</label>
								<input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
							  </div>

							  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>
							</form>
						</div>
						<div class="col-xs-12 col-sm-4">
							<h4 class='city-name'></h4>
							<h5 class='city-date'></h5>
							<h5 class='city-weather'></h5>
							<h3 class='city-temp'><img /><span /></h3>
						</div>
						<div class="col-xs-12 col-sm-8">
							<ul class="list-group">
								<li class="list-group-item justify-content-between wind">
									Wind
									<span class="badge badge-default badge-pill" />
								</li>
								<li class="list-group-item justify-content-between cloudiness">
									Cloudiness
									<span class="badge badge-default badge-pill" />
								</li>
								<li class="list-group-item justify-content-between pressure">
									Pressure
									<span class="badge badge-default badge-pill" />
								</li>
								<li class="list-group-item justify-content-between humidity">
									Humidity
									<span class="badge badge-default badge-pill" />
								</li>
								<li class="list-group-item justify-content-between sunrise">
									Sunrise
									<span class="badge badge-default badge-pill" />
								</li>
								<li class="list-group-item justify-content-between sunset">
									Sunset
									<span class="badge badge-default badge-pill" />
								</li>
							</ul>
						</div>
						<table class="table table-list-search">
							<thead>
								<tr>
									<th>Id</th>
									<th>Country</th>
									<th>City</th>
									<th>Weather</th>
									<th>local Time</th>
									<th>Date time of the request</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>   
					</div>
				</div>
			</div>
         </div>
    </body>
</html>