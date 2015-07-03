<!-- BEGIN: MAIN -->

<script type="text/javascript">
	var myMap;     

	ymaps.ready(function () {

		var centerzoom = {MARK_CENTERZOOM};   
		centercoords = '{MARK_CENTERCOORD}';
		centercoords = centercoords.split(',');

		myMap = new ymaps.Map ("YMapsID", {
			center: centercoords,
			zoom: centerzoom,
		});

		myMap.controls.add(
			new ymaps.control.ZoomControl()
		);

		<!-- BEGIN: MARKS -->
		var mapcoords{MARK_ID} = '{MARK_COORD}';
		mapcoords{MARK_ID} = mapcoords{MARK_ID}.split(',');
		myPlacemark{MARK_ID} = new ymaps.Placemark(mapcoords{MARK_ID}, {
				balloonContentHeader: '{MARK_TITLE}',
				balloonContent: '{MARK_DESC}',
				balloonContentFooter: '<a href="{MARK_URL}"> подробнее </a>'

		}, {
			iconImageHref: 'plugins/placemarks/images/placemark.png', // картинка иконки
			iconImageSize: [73, 46], // размеры картинки
			iconImageOffset: [-20, -50] // смещение картинки
		});
		myMap.geoObjects.add(myPlacemark{MARK_ID});
		
		<!-- END: MARKS -->
	});
	
</script>

<div id="YMapsID" style="height: 500px;"></div>

<!-- END: MAIN -->