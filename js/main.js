$( function() {
	var countryCache = localStorage.getItem('country');
    countryCache = countryCache ? JSON.parse(countryCache) : {};
	cityCache = {};
	
	var getResult = function(request, response, cache, resource){
		var term = request.term;
        if ( term in cache && request.resource_param !== 'city') {
          response( cache[ term ] );
          return;
        }
 
        $.getJSON( "handler.php", request, function( data, status, xhr ) {
			cache[ term ] = data;
			if(request.resource_param !== 'city')
				localStorage.setItem(request.resource_param, JSON.stringify(cache));
			response( data );
        });
	};
	
	var getKeyFromCacheSet = function(cache){
		var response = '';
		for (var initial in cache) {
			var obj = cache[initial];
			for (var code in obj) {
				if(obj[code] == $('#country').val()){
					response = code;
					break;
				}
			}
			if(response) break;
		}
		return response;
	}
	$( "#country" ).autocomplete({
      minLength: 2,
      source: function( request, response ) {
	   request.resource_param = 'country';
       getResult(request, response, countryCache);
      }
    });
	
	$( "#city" ).autocomplete({
      minLength: 2,
      source: function( request, response ) {
		request.resource_param = 'city';
		request.country_code = getKeyFromCacheSet(countryCache);
		getResult(request, response, cityCache);
      }
    });
	
	$( "form" ).on( "submit", function( event ) {
		event.preventDefault();
		$.ajax({
			url: 'handler.php', 
			type : "POST", 
			dataType : 'json', 
			data : $("form").serialize()+'&resource_param=weather'+'&country_code='+getKeyFromCacheSet(countryCache)
		})
		.done(function(data) {
			var cloudiness = data.weather_description;
			$('.city-name').text(data.city+', '+data.country);
			$('.city-date').text(data.dt);
			$('.city-weather').text(cloudiness);
			$('.city-temp img').attr('src', data.icon_url);
			$('.city-temp span').text(data.temp_c+'|'+data.temp_f);
			$('.wind span').text(data.wind_speed+' | '+data.wind_deg);
			$('.cloudiness span').text(cloudiness);
			$('.pressure span').text(data.pressure);
			$('.humidity span').text(data.humidity);
			$('.sunrise span').text(data.sunrise);
			$('.sunset span').text(data.sunset);
		})
		.fail(function(data) {
			alert( "error" );
		});
	});
 } );