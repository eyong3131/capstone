
$(document).ready(function(){
  /**Global variables */
  var obj;
  var high;
  var brgyLayer = L.geoJson(brgy);
  /********Ajax Server Response******/
  /** Cases in District 4 */
  $.get("../control/data/geojson/to_map_cases.php",function(json){
    obj = JSON.parse(json);
  }); 
  /** High Current case Case  */
  $.get("../control/data/geojson/brgy_high.php",function(json){
    high = JSON.parse(json);
  });
  /***********************************/
  console.log(brgy);
  setTimeout(function(){
    /*****Density of color*******/
    function brgyColor(d){
      return d > 25 ? '#800026' :
             d > 18 ? '#BD0026' :
             d > 15 ? '#E31A1C' :
             d > 12 ? '#FC4E2A' :
             d > 9  ? '#FD8D3C' :
             d > 6  ? '#FEB24C' :
             d > 3  ? '#FED976' :
                      '#FFEDA0';
    }
    /***************************/
    /****Color styling****/
    function brgyStyle(feature) {
      return {
          fillColor: brgyColor(feature.properties.density),
          weight: 2,
          opacity: 1,
          color: '#666',
          dashArray: '',
          fillOpacity: 0.7
      };
      }
      /***************************** */
/****Hover Styling******/
    function highlightFeature(e){
      var layer = e.target;
      layer.setStyle(
        {
          weight: 5,
          color: '#666',
          dashArray: '',
          fillOpacity: 0.7
        }
      );
      if(!L.Browser.ie && !L.Browser.opera){
        layer.bringToFront();
      }
    }
    function resetHighlight(e){
      brgyLayer.resetStyle(e.target);
    }
    function zoomToFeature(e){
      map.fitBounds(e.target.getBounds());
    }
    function brgyOnEachFeature(feature, layer){
      layer.bindTooltip(
        feature.properties.density.toString(),
        {noHide: true}
        
        );
      layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: zoomToFeature
      });
    }
    /*********************************/

    /***************Set Defualt View of the map****************/
    var map = L.map('map').setView([14.0229, 121.2827], 12);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      maxZoom: 18,
      scrollWheelZoom:false,
      id: 'mapbox/streets-v11',
      tileSize: 512,
      zoomOffset: -1,
      accessToken: 'pk.eyJ1IjoiZXlvbmczMTMxIiwiYSI6ImNrbHQyamtoNDA5aXUycG1zdGtocHZlNWcifQ.TnRwScwnRu9ezb6XA70dEg'
    }).addTo(map);
    /*******************************/
    map.scrollWheelZoom.disable();
    //associate to map data, find efficient way of doing this
    function mapDetails(){
      if(obj["Sta Monica"] == undefined){
      brgy.features[0].properties.density = 0;
      }else{
      brgy.features[0].properties.density = obj["Sta Monica"];
      }
      if(obj["Sta Veronica"] == undefined){
      brgy.features[1].properties.density = 0;
      }else{
      brgy.features[1].properties.density = obj["Sta Veronica"];
      }
      if(obj["San Bartolome"] == undefined){
      brgy.features[2].properties.density = 0;
      }else{
      brgy.features[2].properties.density = obj["San Bartolome"];
      }
      if(obj["San Roque"] == undefined){
      brgy.features[3].properties.density = 0;
      }else {
      brgy.features[3].properties.density = obj["San Roque"];
      }
      if(obj["Santiago I"] == undefined){
      brgy.features[4].properties.density = 0;
      }else {
      brgy.features[4].properties.density = obj["Santiago I"];
      }
      if(obj["Santiago II"] == undefined){
      brgy.features[5].properties.density = 0;
      }else {
      brgy.features[5].properties.density = obj["Santiago II"];
      }
      if(obj["Bautista"] == undefined){
      brgy.features[6].properties.density = 0 ;
      } else{
      brgy.features[6].properties.density = obj["Bautista"] ;
      }
  }
    mapDetails();
    /***************************/
    brgyLayer = L.geoJson(
      brgy,
        {
          style:brgyStyle,
          onEachFeature:brgyOnEachFeature
        }
    ).addTo(map);
    /************************************************/
    /*************Information Control***************/
    var info = L.control();
    info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
        this.update();
        return this._div;
    };
    
    // method that we will use to update the control based on feature properties passed
    info.update = function (props) {
      var seek;
      try{
        for(var i=6;i>=0;i--){
          if(props.name == high[i]["address"]){
            seek = i;
          }
        }
      }catch(err){
          //do nothing
      }
      this._div.innerHTML = '<h4>District 4 Viral Case</h4>' +  (props ?
        '<b>' + props.name + '</b><br />' + props.density + ' people / Cases</br>' + "Highest Case: " + high[seek]['illness'] + "<br /> Case Count: " +  high[seek]['count']
        
        : 'Hover over a Brgy');

    };
    info.addTo(map);
    function highlightFeature(e) {
      var layer = e.target;
      info.update(layer.feature.properties);
    }
  
    function resetHighlight(e) {
        info.update();
    }
    /******************************/
    /************Legend******************/
    var legend = L.control({position: 'bottomright'});

    legend.onAdd = function (map) {

    var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 1, 2, 3, 4, 5, 6, 10],
        labels = [];

    // loop through our density intervals and generate a label with a colored square for each interval
    for (var i = 0; i < grades.length; i++) {
        div.innerHTML +=
            '<i style="background:' + brgyColor(grades[i] + 1) + '"></i> ' +
            grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
    }

    return div;
  };
  legend.addTo(map);
  //return test = obj;
  /*******************************/
  },500);
});//getJson method
