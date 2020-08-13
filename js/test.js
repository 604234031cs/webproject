function init() {
    map = new longdo.Map({
      placeholder: document.getElementById('map')
    });
    map.location(longdo.LocationMode.Geolocation);

  }


