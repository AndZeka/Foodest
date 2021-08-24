<template>
  <div>
    <div class="custom-control custom-switch ml-2 mb-3 mt-1">
      <input
        type="checkbox"
        class="custom-control-input"
        id="customSwitch1"
        @click="changeMapStyle"
      />
      <label class="custom-control-label" for="customSwitch1" ref="timeToggle">Day</label>
    </div>

    <GmapMap
      ref="mapRef"
      :center="center"
      :zoom="18"
      map-type-id="terrain"
      style="width: 100%; min-height: 500px"
      :options="mapStyle"
    >
      <GmapMarker :position="center" />
      <gmap-info-window
        :opened="home"
        :position="center"
        :options="{
          pixelOffset: {
            width: 0,
            height: -35,
          },
        }"
      >
        Home
      </gmap-info-window>

      <gmap-info-window
        :opened="isCarWindowOpened"
        :position="carLocation"
        :options="{
          pixelOffset: {
            width: 0,
            height: -35,
          },
        }"
      >
        {{ carInfoWindow }}
      </gmap-info-window>

      <gmap-polyline
        v-if="path.length > 0"
        :path="path"
        ref="polyline"
        :options="polylineOptions"
      ></gmap-polyline>
    </GmapMap>
  </div>
</template>

<script>
import data from "./json/data.json";
import nightStyle from "./json/nightStyle.json";
let marker;
let i = 0;

export default {
  data() {
    return {
      path: [
        { lat: 42.66019925135831, lng: 21.158111690726187 },
        { lat: 42.66012035300311, lng: 21.15802586003771 },
        { lat: 42.65999411542652, lng: 21.157934664931204 },
        { lat: 42.65975347433623, lng: 21.157746910300162 },
        { lat: 42.6596627405686, lng: 21.157923936095145 },
        { lat: 42.65955622684636, lng: 21.158460377898123 },
        { lat: 42.6595167772733, lng: 21.158905624594595 },
        { lat: 42.659426043160266, lng: 21.159350871291068 },
        { lat: 42.659386593504614, lng: 21.159608363356497 },
        { lat: 42.659355033762054, lng: 21.159839033331778 },
        { lat: 42.659358978730765, lng: 21.16002678796282 },
        { lat: 42.659429988124444, lng: 21.160219907011893 },
        { lat: 42.65964696076941, lng: 21.16032719537249 },
      ],
      polylineOptions: {
        strokeColor: "black",
      },
      markers: [],
      mapStyle: {},
      carIcon: "/imgs/car.png",
      whiteCarIcon: "/imgs/car-white.png",
      dayStyle: {
        styles: [[]],
      },
      center: {
        lat: 42.659622,
        lng: 21.160308,
      },
      carLocation: {
        lat: 42.66019925135831,
        lng: 21.158111690726187,
      },
      nightOn: false,
      isCarWindowOpened: false,
      carInfoWindow: "Driver",
      home: true,
    };
  },
  mounted() {
    this.$refs.mapRef.$mapPromise.then(() => {
      this.initSlidingMarker(this.$refs.mapRef.$mapObject);
    });

    this.moveCar();
    this.animatePolyline();
  },
  methods: {
    changeMapStyle() {
      this.nightOn = !this.nightOn;
      this.mapStyle = this.nightOn ? nightStyle : this.dayStyle;
      marker.setIcon(this.nightOn ? this.whiteCarIcon : this.carIcon);
      this.$refs.timeToggle.innerText = this.nightOn ? 'Night':'Day';
    },
    initSlidingMarker(map) {
      const SlidingMarker = require("marker-animate-unobtrusive");
      SlidingMarker.initializeGlobally();
      marker = new SlidingMarker({
        position: this.carLocation,
        map: map,
        title: "I am sliding marker",
        icon: this.carIcon,
      });
    },
    moveCar() {
      let v = this;
      setTimeout(function () {
        if (data.features[i]) {
          const toLat = data.features[i].geometry.coordinates[0];
          const toLng = data.features[i].geometry.coordinates[1];
          const bearing = v.$bearing(
            v.carLocation.lat,
            v.carLocation.lng,
            toLat,
            toLng
          );
          let distance = v.$distance(
            v.center.lat,
            v.center.lng,
            toLat,
            toLng
          );
          v.carLocation = { lat: toLat, lng: toLng };
          marker.setEasing("linear");
          marker.setPosition(v.carLocation);

          $('img[src*="car.png"]').css(
            "transform",
            "rotate(" + bearing + "deg)"
          );
          $('img[src*="car-white.png"]').css(
            "transform",
            "rotate(" + bearing + "deg)"
          );
          if (distance <= 25) {
            v.isCarWindowOpened = true;
            v.carInfoWindow = "Driver Here";
          }

          i += 1;
          v.moveCar();
        }
      }, 1000);
    },
    animatePolyline() {
      let isPolylineBlack = true;
      let currentOptions;
      let v = this;

      function togglePolyline() {
        if (isPolylineBlack) {
          currentOptions = { strokeColor: "gray" };
          isPolylineBlack = false;
        } else {
          currentOptions = { strokeColor: "black" };
          isPolylineBlack = true;
        }

        v.polylineOptions = currentOptions;
      }

      setInterval(togglePolyline, 1000);
    },
  },
};
</script>

<style>
.custom-control-label {
  position: relative;
  margin-bottom: 0;
  vertical-align: top;
}

.custom-control-input {
  position: absolute;
  z-index: -1;
  opacity: 0;
}

.custom-switch {
  padding-left: 2.25rem;
}

.custom-control {
  position: relative;
  display: block;
  min-height: 1.5rem;
  padding-left: 1.5rem;
}

.custom-control-input:checked ~ .custom-control-label::before {
  color: #fff;
  border-color: #0b55c1;
  background-color: #0b55c1;
}

.custom-switch .custom-control-label::before {
  left: -2.25rem;
  width: 1.75rem;
  pointer-events: all;
  border-radius: 0.5rem;
}

.custom-control-label::before,
.custom-file-label,
.custom-select {
  transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out,
    box-shadow 0.15s ease-in-out;
}

.custom-control-label::before {
  position: absolute;
  top: 0.25rem;
  left: -1.5rem;
  display: block;
  width: 1rem;
  height: 1rem;
  pointer-events: none;
  content: "";
  background-color: #fff;
  border: #adb5bd solid 1px;
}

.custom-switch .custom-control-input:checked ~ .custom-control-label::after {
  background-color: #fff;
  -webkit-transform: translateX(0.75rem);
  transform: translateX(0.75rem);
}

.custom-switch .custom-control-label::after {
  top: calc(0.25rem + 2px);
  left: calc(-2.25rem + 2px);
  width: calc(1rem - 4px);
  height: calc(1rem - 4px);
  background-color: #adb5bd;
  border-radius: 0.5rem;
  transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out,
    box-shadow 0.15s ease-in-out, -webkit-transform 0.15s ease-in-out;
  transition: transform 0.15s ease-in-out, background-color 0.15s ease-in-out,
    border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  transition: transform 0.15s ease-in-out, background-color 0.15s ease-in-out,
    border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out,
    -webkit-transform 0.15s ease-in-out;
}

.custom-control-label::after {
  position: absolute;
  top: 0.25rem;
  left: -1.5rem;
  display: block;
  width: 1rem;
  height: 1rem;
  content: "";
  background: no-repeat 50%/50% 50%;
}
</style>

