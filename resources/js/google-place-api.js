
$(function () {
  requestUserLocation();
});

export function initGooglePlaceElements(elementClass) {
  const inputs = document.getElementsByClassName(elementClass);

  // Itera sobre todos los elementos con la clase dada
  Array.from(inputs).forEach((input) => {
    const autocomplete = new google.maps.places.Autocomplete(input, {
      types: ["geocode"],
    });

    autocomplete.addListener("place_changed", function () {
      const place = autocomplete.getPlace();

      if (!place.geometry) {
        console.error("No se encontró la ubicación");
        return;
      }

      // Aquí, si es necesario, asignar la latitud y longitud a campos específicos
      // Podrías manejar estos campos de forma dinámica o específica por cada input
      // const latitudeInput = input.closest("form").querySelector(".latitude"); // Busca el campo de latitud más cercano
      // const longitudeInput = input.closest("form").querySelector(".longitude"); // Busca el campo de longitud más cercano

      // if (latitudeInput) latitudeInput.value = place.geometry.location.lat();
      // if (longitudeInput) longitudeInput.value = place.geometry.location.lng();
    });
  });
}

export function requestUserLocation() {
  if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        console.log("Ubicación obtenida:", lat, lng);

        getPlaceDetailsFromCoords(lat, lng);

      },
      (error) => {
        console.error("Error obteniendo ubicación:", error.message);
      }
    );
  } else {
    console.error("Geolocalización no soportada en este navegador.");
  }
}

export function getPlaceDetailsFromCoords(lat, lng) {
  const apiKey = import.meta.env.VITE_MAPS_API_KEY; // Asegúrate de pasar tu API Key correctamente
  const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${apiKey}`;
  
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      console.log("Datos de geocoding:", data);
      
      if (data.status === "OK") {
        const place = data.results[0]; // Tomamos el primer resultado

        const placeId = place.place_id;
        const placeName = place.formatted_address;

        console.log("Place ID:", placeId);
        console.log("Place Name:", placeName);

      } else {
        console.error("No se encontraron detalles del lugar");
      }
    })
    .catch((error) => console.error("Error en la solicitud de geocoding:", error));
}