<!-- BEGIN: MAIN -->

<div id="YMapsID" style="height: 700px;"></div>
<input type="hidden" name="rcoord" value="{MARK_COORD}"/>
<input type="hidden" name="rzoom" value="{MARK_ZOOM}"/>

<script type="text/javascript">
	var myMap;     

	ymaps.ready(function () {

		var plmset = false;
		var mapcoords = $("input[name=rcoord]").val();
		var mapzoom = $("input[name=rzoom]").val(); 

		if(!mapzoom){
			mapzoom = 12;
		} 

		if(mapcoords > '')
		{
			 mapcoords = mapcoords.split(',');
			 plmset = true;
		}
		else
		{
			var latitude = ymaps.geolocation.latitude || 55.76;
			var longitude = ymaps.geolocation.longitude || 37.64;
			
			mapcoords = [latitude, longitude];
		}    

		myMap = new ymaps.Map ("YMapsID", {
			center: mapcoords,
			zoom: mapzoom,
		});

		myMap.controls.add(
			new ymaps.control.ZoomControl()
		);

		myMap.controls.add(
			new ymaps.control.SearchControl({provider: 'yandex#publicMap',  useMapBounds: true})
		);
		
		if(plmset)
		{
			myPlacemark = new ymaps.Placemark(mapcoords, {
				balloonContent: 'Placemark'
			}, {
				iconImageHref: 'plugins/placemarks/images/placemark.png', // картинка иконки
				iconImageSize: [73, 46], // размеры картинки
				iconImageOffset: [-20, -50] // смещение картинки
			});	

			myMap.geoObjects.add(myPlacemark);
		}
		
		myMap.events.add("click",
			function(e) {
				myReverseGeocoder = ymaps.geocode(e.get("coords"));
				myReverseGeocoder.then(
					function (res) {
						var names = [];
						res.geoObjects.each(function (obj) {
							names.push(obj.properties.get('name'));
						});
						addr = names.reverse().join(', ');

						if(plmset)
						{
							myMap.geoObjects.remove(myPlacemark);
						}

						myPlacemark = new ymaps.Placemark(e.get("coords"), {
							balloonContent: addr
						}, {
							iconImageHref: 'plugins/placemarks/images/placemark.png', // картинка иконки
							iconImageSize: [73, 46], // размеры картинки
							iconImageOffset: [-20, -50] // смещение картинки
						});												
						myMap.geoObjects.add(myPlacemark);												

						plmset = true;
						$("input[name=rcoord]").val(e.get("coords"));
						$("input[name=rzoom]").val(myMap.getZoom());
					},
					function (err) {
						alert('Ошибка');
					}
				);
			}
		);
	});
	
</script>
<!-- END: MAIN -->