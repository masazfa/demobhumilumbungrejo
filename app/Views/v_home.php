<div id="loading">
    <img id="loading-image" src="loading1.gif" alt="Loading..." />
  </div>

  <script>
$('form').submit(function(e) {
  e.preventDefault();
  $("#loading").fadeIn(500);
  $("#loading-image").fadeIn(500);
  setTimeout(function(){
    $("#loading").fadeOut(500);
    $("#loading-image").fadeOut(500);
  }, 10000); // Increased to 10 seconds
});

  </script>

<style>
#loading {
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  position: fixed;
  display: none;
  opacity: 1;
  background-color: #fff;
  z-index: 9999;
  text-align: center;
}

#loading-image {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 10000;
}
  </style>

<!-- Pencarian -->
<?php
// Koneksi ke database
$db = new PDO('mysql:host=localhost;dbname=bhumilumbungrejo', 'root', '');

// Query untuk mendapatkan data dari tabel "tanah"
$stmt = $db->prepare("SELECT pemilik FROM tanah");
$stmt->execute();

// Fetch semua data
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// opsi pemilik
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['keywordtanah'])) {
  // Ambil keyword dari form
  $keywordtanah = $_POST['keywordtanah'];

  // Buat query SQL
  $sql = "SELECT * FROM tanah WHERE pemilik LIKE :keywordtanah";

  // Siapkan statement
  $stmt = $db->prepare($sql);

  // Bind parameter
  $stmt->bindValue(':keywordtanah', '%' . $keywordtanah . '%');

  // Eksekusi statement
  $stmt->execute();

  // Fetch semua hasil
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Inisialisasi layertanahmerah
  $layertanahmerah = [
      "type" => "FeatureCollection",
      "name" => "tanah",
      "crs" => ["type" => "name", "properties" => ["name" => "urn:ogc:def:crs:OGC:1.3:CRS84"]],
      "features" => []
  ];

  // Check if results are not empty
  if(!empty($results)) {
    // Loop melalui semua hasil dan tambahkan ke layertanahmerah
    foreach ($results as $row) {
        $feature = [
            "type" => "Feature",
            "properties" => [
                "id" => $row['id'],
                "luas" => $row['luas'],
                "keliling" => $row['keliling'],
                "pemilik" => $row['pemilik'],
                "nik" => $row['nik'],
                "narahubung" => $row['narahubung'],
                "dokumen" => $row['dokumen'],
                "luastanah" => $row['luastanah'],
                "status" => $row['status'],
                "sumberdata" => $row['sumberdata'],
            ],
            "geometry" => [
                "type" => "MultiPolygon",
                "coordinates" => json_decode($row['data_spasial'], true)
            ]
        ];
        $layertanahmerah['features'][] = $feature;
    }
  }

  // Konversi layertanahmerah ke JSON
  $layertanahmerah_json = json_encode($layertanahmerah);
}

// opsi nik
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['keywordnik'])) {
  // Ambil keyword dari form
  $keywordnik = $_POST['keywordnik'];

  // Buat query SQL
  $sql = "SELECT * FROM tanah WHERE nik LIKE :keywordnik";

  // Siapkan statement
  $stmt = $db->prepare($sql);

  // Bind parameter
  $stmt->bindValue(':keywordnik', '%' . $keywordnik . '%');

  // Eksekusi statement
  $stmt->execute();

  // Fetch semua hasil
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Inisialisasi layertanahmerah
  $layertanahmerahnik = [
      "type" => "FeatureCollection",
      "name" => "tanah",
      "crs" => ["type" => "name", "properties" => ["name" => "urn:ogc:def:crs:OGC:1.3:CRS84"]],
      "features" => []
  ];

  // Loop melalui semua hasil dan tambahkan ke layertanahmerah
  foreach ($results as $row) {
      $feature = [
          "type" => "Feature",
          "properties" => [
              "id" => $row['id'],
              "luas" => $row['luas'],
              "keliling" => $row['keliling'],
              "pemilik" => $row['pemilik'],
              "nik" => $row['nik'],
              "narahubung" => $row['narahubung'],
              "dokumen" => $row['dokumen'],
              "luastanah" => $row['luastanah'],
              "status" => $row['status'],
              "sumberdata" => $row['sumberdata'],
          ],
          "geometry" => [
              "type" => "MultiPolygon",
              "coordinates" => json_decode($row['data_spasial'], true)
          ]
      ];
      $layertanahmerahnik['features'][] = $feature;
  }

  // Konversi layertanahmerah ke JSON
  $layertanahmerahnik_json = json_encode($layertanahmerahnik);
}
?>

<div id="map" style="height :100vh;"></div>
<div id="logo-container">
  <div id="inner-container">
    <img src="<?=base_url()?>logo_bhumi.jpg" alt="Logo">
    <div id="arrow">▼</div>
  </div>
</div>

<form href="" method="post">
<div id="search-container" class="input-group mb-3">
  <input id="searchInput" list="tanah-data" class="form-control" placeholder="Cari..." name="keywordtanah" aria-label="Cari" aria-describedby="button-addon2" style="border-radius: 20px 0 0 20px; border-right: none;">
  <datalist id="tanah-data" style="height: 100px; overflow-y: auto;">
    <?php foreach ($data as $row): ?>
      <option value="<?= $row['pemilik'] ?>">
    <?php endforeach; ?>
  </datalist>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="submit" id="button-addon2" style="border-radius: 0 20px 20px 0; border-left: none; background-color: #6c757d; color: white;">
    <i class="fa fa-search"></i>
    </button>
  </div>
</div>
<div id="search-type" class="input-group mb-3">
  <select class="form-control select-css" id="searchType" name="searchType" style="border-radius: 20px;background-color:white;" onchange="changeInputName()">
    <option value="type1">Pemilik</option>
    <option value="type2">NIK</option>
  </select>
</div>
</form>

<!-- Akhir Pencarian -->

<!-- Location Lat Lng -->
<div id="coordinate-container" style="position: absolute; bottom: 10px; left: 10px; background-color: white; border-radius: 5px 5px 5px 5px; padding: 5px; z-index: 1000;">
  <a id="lat" style="padding: 0 10px; font-size: 0.8em;"></a>
  <a id="lng" style="padding: 0 10px; font-size: 0.8em;"></a>
</div>

<!-- Location Lat Lng -->

<div id="popup-logo-container" style="display: none; border-radius: 10px;">
  <ul>
    <li><a href="" style="color:black;">Bantuan</a></li>
    <li><a href="" style="color:black;">Login</a></li>
  </ul>
</div>


<script>
  // Add this to your JavaScript
$('form').submit(function(e) {
  $("#loading").show();
  setTimeout(function(){
    $("#loading").hide();
  }, 5000);
});

  // option pencarian
  function changeInputName() {
  var searchType = document.getElementById("searchType").value;
  var searchInput = document.getElementById("searchInput");

  if (searchType == "type1") {
    searchInput.name = "keywordtanah";
  } else if (searchType == "type2") {
    searchInput.name = "keywordnik";
  }
}

  document.getElementById('arrow').addEventListener('click', function() {
  var popupLogoContainer = document.getElementById('popup-logo-container');
  if (popupLogoContainer.style.display == "none") {
    popupLogoContainer.style.display = "block";
    setTimeout(function(){ popupLogoContainer.style.opacity = "1"; }, 50);
  } else {
    popupLogoContainer.style.opacity = "0";
    setTimeout(function(){ popupLogoContainer.style.display = "none"; }, 500);
  }
});
  //basemap
  var map = L.map('map', {
    zoom: 15,
    center: L.latLng([-7.916181, 110.095629]),
  });
    // osmLayer = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

  map.addControl(
    L.control.locate({
      locateOptions: {
        flyTo: true,
        minzoom: 15,
        initialZoomLevel: 17,
      }
    })
  );

  // L.control.rotate().addTo(map);

  L.control.measure({
    position: 'topleft',
    primaryLengthUnit: 'meters',
    secondaryLengthUnit: undefined,
    primaryAreaUnit: 'sqmeters',
    secondaryAreaUnit: undefined,
  }).addTo(map);

  function updateLatLng(e) {
  document.getElementById('lat').textContent = 'Lat: ' + e.latlng.lat.toFixed(5);
  document.getElementById('lng').textContent = 'Long: ' + e.latlng.lng.toFixed(5);
}

map.on('mousemove', updateLatLng);

L.control.scale({position: 'bottomright', metric: true}).addTo(map);

  // Layer
  var layertanah = {
    "type": "FeatureCollection",
    "name": "tanah",
    "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" } },
    "features": [
      <?php
      // Check if $id is not null
      if ($idtanah !== null) {
        // Search for the key of the row with the id equal to $id
        foreach ($tanah as $key => $value) {
          if ($value['id'] == $idtanah) {
            // Remove the row from its current position and add it at the end of the array
            unset($tanah[$key]);
            $tanah[] = $value;
          }
        }
      }

      // Now you can loop through your array as usual
      foreach ($tanah as $key => $value): ?>{
          "type": "Feature",
          "properties": {
            "id": <?= $value['id']?>,
            "luas": "<?= $value['luas']?>",
            "keliling": "<?= $value['keliling']?>",
            "pemilik": "<?= $value['pemilik']?>",
            "nik": "<?= $value['nik']?>",
            "narahubung": "<?= $value['narahubung']?>",
            "dokumen": "<?= $value['dokumen']?>",
            "luastanah": "<?= $value['luastanah']?>",
            "status": "<?= $value['status']?>",
            "sumberdata": "<?= $value['sumberdata']?>",
          },
          "geometry": {
            "type": "MultiPolygon",
            "coordinates": <?= $value['data_spasial']?>
          }
        },
      <?php endforeach; ?>
    ]
  };

  // View
  var viewtanah = new L.geoJSON(layertanah, {
  style: function (feature) {
    return {
      opacity: 1.5,
      color: 'green',
      fillColor: 'green',
      fillOpacity: 0.5,
      weight: 1.5,
    };
  },
  onEachFeature: function (feature, marker, latlng, title, map) {
    marker.bindPopup('<img src = "<?= base_url() ?>foto/' + feature.properties.dokumen + '"width = 250px;"><br><br>' + "<div style='auto;overflow:auto;'><table>" +
      "<tr><th>Pemilik</th><td>" + " : " + feature.properties.pemilik + "</td></tr>" +
      "<tr><th>NIK</th><td>" + " : " + feature.properties.nik + "</td></tr>" +
      "<tr><th>Narahubung</th><td>" + " : " + feature.properties.narahubung + "</td></tr>" +
      "<tr><th>Luas (m2)</th><td>" + " : " + feature.properties.luas + "</td></tr>" +
      "<tr><th>Keliling (m)</th><td>" + " : " + feature.properties.keliling + "</td></tr>" +
      "<tr><th>Status</th><td>" + " : " + feature.properties.status + "</td></tr>" +
      "<tr><th>Sumber Data</th><td>" + " : " + feature.properties.sumberdata + "</td></tr>" +
    "</table></div>")
  }
});

map.addLayer(viewtanah);

<?php if (isset($layertanahmerah_json)): ?>
var layertanahmerah = <?php echo $layertanahmerah_json; ?>;

var viewtanahmerah = new L.geoJSON(layertanahmerah, {
  style: function (feature) {
    return {
      opacity: 1.5,
      color: 'red',
      fillColor: 'red',
      fillOpacity: 0.5,
      weight: 1.5,
    };
  },
  onEachFeature: function (feature, layer) {
    layer.bindPopup('<img src = "<?= base_url() ?>foto/' + feature.properties.dokumen + '"width = 250px;"><br><br>' + "<div style='height:auto;overflow:auto;'><table>" +
      "<tr><th>Pemilik</th><td>" + " : " + feature.properties.pemilik + "</td></tr>" +
      "<tr><th>NIK</th><td>" + " : " + feature.properties.nik + "</td></tr>" +
      "<tr><th>Narahubung</th><td>" + " : " + feature.properties.narahubung + "</td></tr>" +
      "<tr><th>Luas (m2)</th><td>" + " : " + feature.properties.luas + "</td></tr>" +
      "<tr><th>Keliling (m)</th><td>" + " : " + feature.properties.keliling + "</td></tr>" +
      "<tr><th>Status</th><td>" + " : " + feature.properties.status + "</td></tr>" +
      "<tr><th>Sumber Data</th><td>" + " : " + feature.properties.sumberdata + "</td></tr>" +
    "</table></div>");
  }
}).addTo(map);

// Check if bounds are valid before fitting map
if (viewtanahmerah.getBounds().isValid()) {
  // Zoom ke batas dari layertanahmerah
  map.fitBounds(viewtanahmerah.getBounds());
} else {
  console.log('Bounds are not valid.');
}
<?php endif; ?>

<?php if (isset($layertanahmerahnik_json)): ?>
var layertanahmerahnik = <?php echo $layertanahmerahnik_json; ?>;

var viewtanahmerahnik = new L.geoJSON(layertanahmerahnik, {
  style: function (feature) {
    return {
      opacity: 1.5,
      color: 'red',
      fillColor: 'red',
      fillOpacity: 0.5,
      weight: 1.5,
    };
  },
  onEachFeature: function (feature, layer) {
    layer.bindPopup('<img src = "<?= base_url() ?>foto/' + feature.properties.dokumen + '"width = 250px;"><br><br>' + "<div style='height:auto;overflow:auto;'><table>" +
      "<tr><th>Pemilik</th><td>" + " : " + feature.properties.pemilik + "</td></tr>" +
      "<tr><th>NIK</th><td>" + " : " + feature.properties.nik + "</td></tr>" +
      "<tr><th>Narahubung</th><td>" + " : " + feature.properties.narahubung + "</td></tr>" +
      "<tr><th>Luas (m2)</th><td>" + " : " + feature.properties.luas + "</td></tr>" +
      "<tr><th>Keliling (m)</th><td>" + " : " + feature.properties.keliling + "</td></tr>" +
      "<tr><th>Status</th><td>" + " : " + feature.properties.status + "</td></tr>" +
      "<tr><th>Sumber Data</th><td>" + " : " + feature.properties.sumberdata + "</td></tr>" +
    "</table></div>");
  }
}).addTo(map);

// Check if bounds are valid before fitting map
if (viewtanahmerahnik.getBounds().isValid()) {
  // Zoom ke batas dari layertanahmerah
  map.fitBounds(viewtanahmerahnik.getBounds());
} else {
  console.log('Bounds are not valid.');
}
<?php endif; ?>

const bmList = [
  {
		layer :  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{attribution:"&copy; <a href=\\\"https://www.openstreetmap.org/copyright\\\">OpenStreetMap</a> contributors"}).addTo(map),
		name : "Open Street Map",
		icon : "<?=base_url()?>leaflet/leaflet-bmswitcher-main/example/assets/osm.png"
    },
	{
		layer :  L.tileLayer("http://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}.png",{attribution:"Map data © <a href=\\\"http://openstreetmap.org\\\">OpenStreetMap</a> contributors"}),
		name : "ArcGIS Online",
		icon : "<?=base_url()?>leaflet/leaflet-bmswitcher-main/example/assets/arcgis-online.png"
    },
	{
		layer :  L.tileLayer("http://services.arcgisonline.com/arcgis/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}",{attribution:"&copy; <a href=\\\"https://www.openstreetmap.org/copyright\\\">OpenStreetMap</a> contributors"}),
		name : "ESRI Light Gray",
		icon : "<?=base_url()?>leaflet/leaflet-bmswitcher-main/example/assets/esri-light-gray.png"
    },
	{
		layer :  L.tileLayer("http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}", {maxZoom: 20,subdomains: ['mt0', 'mt1', 'mt2', 'mt3']},{attribution:"&copy; <a href=\\\"https://www.openstreetmap.org/copyright\\\">OpenStreetMap</a> contributors"}),
		name : "Google Satellite",
		icon : "<?=base_url()?>leaflet/leaflet-bmswitcher-main/example/assets/google.png"
    },
];
new L.bmSwitcher(bmList).addTo(map);

var returncenter = L.Control.extend({
    options: {
        position: 'topleft'
    },

    onAdd: function (map) {
        var container = L.DomUtil.create('button', 'leaflet-bar leaflet-control leaflet-control-custom');

        container.style.backgroundColor = 'white'; 
        container.style.backgroundSize = "30px 30px";
        container.style.width = '34px';
        container.style.marginBottom = '10px';
        container.style.height = '35px';

        // Membuat tombol dengan ikon SVG
        container.innerHTML = '<img src="<?=base_url()?>pin-location-svgrepo-com.svg" width="25" height="25" style="position: relative; top: 43%; left: 50%; transform: translate(-50%, -50%);">';


        container.onclick = function(){
          map.setView([-7.916181, 110.095629], 15);
        }

        return container;
    },
});

map.addControl(new returncenter());

var baseLayers = [
    // {
    //   active: false,
    //   name: "Open Street Map",
    //   layer: osmLayer
    // },
    // {
    //   active:true,
    //   name: "Satellite",
    //   layer: L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
    //     maxZoom: 20,
    //     subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    //   })
    // },
    // {
    //   active:true,
    //   name: "ESRI Light Gray",
    //   layer: L.tileLayer('http://services.arcgisonline.com/arcgis/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
    //   maxZoom: 22
    // })},
  ];
  // panel layer
  var overLayers = [
    {
      group: "Polygon",
      layers: [
        {
          active: true,
          name: "Layer Tanah",
          icon: '<i class="icon" style="background-color:green"></i>',
          layer: viewtanah
        },
      ]
    },
  ];

  // var isMobile = window.innerWidth <= 480; // Adjust as needed

  var panelbutton = L.Control.extend({
    options: {
        position: 'topright'
    },

    onAdd: function (map) {
        var container = L.DomUtil.create('button', 'leaflet-bar leaflet-control leaflet-control-custom');

        container.style.backgroundColor = 'white'; 
        container.style.backgroundSize = "30px 30px";
        container.style.width = '40px';
        container.style.marginBottom = '10px';
        container.style.height = '40px';

        // Membuat tombol dengan ikon SVG
        container.innerHTML = '<img src="<?=base_url()?>assets/stack.svg" width="25" height="25" style="position: relative; top: 43%; left: 50%; transform: translate(-50%, -50%);">';

        container.onclick = function(){
            var panel = $(panelLayers.getContainer());
            if(panel.css('display') === "none") {
                panel.animate({width: 'toggle'}); // Menambahkan animasi geser ke kanan saat membuka
            } else {
                panel.animate({width: 'toggle'}); // Menambahkan animasi geser ke kiri saat menutup
            }
        }

        return container;
    },
});

map.addControl(new panelbutton());

var panelLayers = new L.Control.PanelLayers(baseLayers, overLayers, {
    selectorGroup: true,
    collapsibleGroups: true,
    collapsed: false // Panel layer selalu dalam keadaan collapsed
});

map.addControl(panelLayers);

</script>

<style>
    .leaflet-panel-layers.expanded{
    display:none;
  }
  .leaflet-panel-layers-base{
    display:none;
  }

  .leaflet-panel-layers-separator{
    display:none;
  }

  .leaflet-left{
    top:12vh;
  }

  #popup-logo-container ul li {
  margin-bottom: 10px;
  margin-top:15px;
  }

  #logo-container {
    margin-top:1vh;
    margin-left:1vh;
    background-color: white;
    border-radius: 10px;
    width: 35vh;
    height: 10vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1000;
  }

  #inner-container {
    background-color: white;
    border: 2px solid gray;
    border-radius: 10px;
    width: 32vh;
    height: 8vh;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  #inner-container img {
    max-width: 100%;
    max-height: 100%;
  }
  #arrow {
    cursor: pointer;
    margin-left: 10px;
  }

  #popup-logo-container {
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
    margin-top:12vh;
    margin-left:8vh;
    background-color: white;
    border-radius: 10px;
    width: 35vh;
    height: 15vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1000;
  }

  /* #popup-logo-container:not(.hidden) {
    opacity: 1;
  } */
  .styleLabelZNT {
    background: rgba(255, 255, 255, 0);
    border: 0;
    border-radius: 0px;
    box-shadow: 0 0px 0px;
    font-size: 8pt;
    color: white;
    text-shadow: 2px 2px 5px black;
    font-weight: bold;
  }

  .leaflet-panel-layers-list{
    height:50vh;
  }

  #sidebar {
    position: absolute;
    z-index: 9000;
    /* This will make the sidebar appear above the map */
    width: 20%;
    /* Adjust as needed */
  }

  .leaflet-panel-layers.expanded {
  border-bottom-left-radius: 10px;
  border-top-left-radius: 10px;
  }

  .leaflet-control-attribution {
    display: none;
  }

  .title-page {
    display:none;
  }

  .text-subtitle {
    display:none;
  }
  #main .main-content {
    padding:0;
  }

  .select-css {
    background-image:
    url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="6"><path fill="black" d="M0 0h12L6 6z"/></svg>');
    background-repeat: no-repeat;
    background-position: right .7em top 50%, 0 0;
    background-size: .65em auto, 100%;
}

.select-css option {
    transition: background-color 0.5s ease;
}

.select-css option:hover {
    background-color: #f2f2f2;
}

#search-container{
  position: absolute; 
  left: 38vh; 
  top: 7px; 
  z-index: 1000; 
  width: 55vh;
}

#search-type{
  position: absolute; 
  left: 94vh; 
  top: 7px; 
  z-index: 1000; 
  width: 12vh;
}

@media (max-width: 732px) {
  .leaflet-left{
    top:20vh;
  }
  #search-container{
  left: 1vh;
  top: 13vh;
  width:31vh;
  }
  #search-type{
    top:13vh;
    left:33vh;
  }
  .leaflet-panel-layers-list{
    height: 50vh;
  }
  .leaflet-panel-layers.expanded{
    top:13vh;
  }
}
</style>