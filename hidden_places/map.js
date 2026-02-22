let map;
let markerLayer = L.layerGroup();

// 1. Custom Icon Definitions
const hospitalIcon = L.icon({
    iconUrl: 'https://cdn-icons-png.flaticon.com/512/504/504244.png',
    iconSize: [35, 35], iconAnchor: [17, 34], popupAnchor: [0, -30]
});

const hotelIcon = L.icon({
    iconUrl: 'https://cdn-icons-png.flaticon.com/512/2983/2983973.png',
    iconSize: [32, 32], iconAnchor: [16, 32], popupAnchor: [0, -30]
});

const restoIcon = L.icon({
    iconUrl: 'https://cdn-icons-png.flaticon.com/512/3448/3448609.png',
    iconSize: [32, 32], iconAnchor: [16, 32], popupAnchor: [0, -30]
});

const fuelIcon = L.icon({
    iconUrl: 'https://cdn-icons-png.flaticon.com/512/483/483497.png',
    iconSize: [32, 32], iconAnchor: [16, 32], popupAnchor: [0, -30]
});

const mechanicIcon = L.icon({
    iconUrl: 'https://cdn-icons-png.flaticon.com/512/1037/1037974.png',
    iconSize: [32, 32], iconAnchor: [16, 32], popupAnchor: [0, -30]
});

const destinationIcon = L.icon({
    iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
    iconSize: [35, 35], iconAnchor: [17, 35], popupAnchor: [0, -35]
});

// 2. Distance Calculation (Haversine Formula)
function getDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; 
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return (R * c).toFixed(1);
}

// 3. Main Map Modal Function
function openMapModal(lat, lng, type) {
    document.getElementById('mapModal').style.display = 'flex';
    
    const titles = { 
        'hospital': 'Nearby Medical Centers', 
        'hospitality': 'Hotels & Restaurants', 
        'fuel': 'Petrol Pumps', 
        'car_repair': 'Mechanics' 
    };
    document.getElementById('mapTitle').innerText = titles[type] || "Nearby Services";

    if (!map) {
        map = L.map('map-container').setView([lat, lng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    } else {
        map.setView([lat, lng], 13);
    }

    markerLayer.clearLayers();
    markerLayer.addTo(map);

    // Marker for the actual tourist spot
    L.marker([lat, lng], {icon: destinationIcon}).addTo(markerLayer)
        .bindPopup("<b>Target Destination</b>").openPopup();

    // Smart Query Construction
    let queryFilter = `node["amenity"="${type}"](around:30000,${lat},${lng});`;
    
    if(type === 'hospitality') {
        queryFilter = `(
            node["amenity"="restaurant"](around:30000,${lat},${lng});
            node["tourism"~"hotel|guest_house|resort"](around:30000,${lat},${lng});
        );`;
    }

    const osmUrl = `https://overpass-api.de/api/interpreter?data=[out:json];${queryFilter}out;`;

    fetch(osmUrl)
        .then(res => res.json())
        .then(data => {
            if(data.elements.length === 0) {
                alert("No services found within 30km of this location.");
            }

            data.elements.forEach(item => {
                // Icon Selection Logic
                let iconToUse = mechanicIcon;
                if(type === 'fuel') iconToUse = fuelIcon;
                if(type === 'hospital') iconToUse = hospitalIcon;
                if(type === 'hospitality') {
                    iconToUse = (item.tags.tourism) ? hotelIcon : restoIcon;
                }
                
                const dist = getDistance(lat, lng, item.lat, item.lon);

                L.marker([item.lat, item.lon], {icon: iconToUse}).addTo(markerLayer)
                    .bindPopup(`
                        <div style="font-family: sans-serif;">
                            <b style="color: #2d6a4f;">${item.tags.name || "Service Provider"}</b><br>
                            <span style="font-weight: bold;">📍 Distance: ${dist} KM</span><br>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${item.lat},${item.lon}" 
                               target="_blank" style="color: #2d6a4f; font-weight: bold; text-decoration: none;">
                               → Get Directions
                            </a>
                        </div>
                    `);
            });
        })
        .catch(err => console.error("API Error:", err));
}

function closeMap() {
    document.getElementById('mapModal').style.display = 'none';
}