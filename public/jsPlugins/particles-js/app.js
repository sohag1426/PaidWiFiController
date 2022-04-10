/*
particlesJS takes two arguments:
1) the element you want it to be displayed onto (#particles-js), and 
2) the json configuration.

configuration has two main objects, 
1) particles for controlling the look and feel of the particles, and 
2) interactivity for handling all of the effects.

*/
particlesJS("particles-js", {
  "particles": {
    "number": {
      "value": 6,
      "density": {
        "enable": true,
        "value_area": 800 // Denser the smaller the number.
      }
    },
    "color": { // The color for every node, not the connecting lines.
      "value": "#1b1e34" // Or use an array of colors like ["#9b0000", "#001378", "#0b521f"]
    },
    "shape": {
      "type": "polygon", // Can show circle, edge (a square), triangle, polygon, star, img, or an array of multiple.
      "stroke": { // The border
        "width": 0,
        "color": "#000"
      },
      "polygon": { // if the shape is a polygon
        "nb_sides": 6
      },
      "image": { // If the shape is an image
        "src": "",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 0.3,
      "random": true,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.1,
        "sync": false
      }
    },
    "size": {
      "value": 160,
      "random": false,
      "anim": {
        "enable": true,
        "speed": 10,
        "size_min": 40,
        "sync": false
      }
    },
    "line_linked": {
      "enable": false,
      "distance": 200, // The radius before a line is added, the lower the number the more lines.
      "color": "#ffffff",
      "opacity": 1,
      "width": 2
    },
    "move": {
      "enable": true,
      "speed": 8,
      "direction": "none", // Move them off the canvas, either "none", "top", "right", "bottom", "left", "top-right", "bottom-right" et cetera...
      "random": false,
      "straight": false, // Whether they'll shift left and right while moving.
      "out_mode": "out", // What it'll do when it reaches the end of the canvas, either "out" or "bounce".
      "bounce": false,
      "attract": { // Make them start to clump together while moving.
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    // activate
    "events": {
      "onhover": {
        "enable": false,
        "mode": "grab"
      },
      "onclick": {
        "enable": false,
        "mode": "push"
      },
      "resize": true
    },
    // configure
    "modes": {
      "grab": {
        "distance": 400,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 400,
        "size": 40,
        "duration": 2,
        "opacity": 8,
        "speed": 3
      },
      "repulse": {
        "distance": 200,
        "duration": 0.4
      },
      "push": {
        "particles_nb": 4
      },
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
});
