"use strict";

//get all svg paths(cities)
const cities = document.querySelectorAll("path");
cities.forEach(city => {

    //get city name
    const text = city.parentElement.querySelector('text');

    city.addEventListener('mouseenter', () => {
        city.style.fill = '#232b2b';
    });
    city.addEventListener('mouseleave', () => {
        city.style.fill = '#a9a9a9';
    });

    city.addEventListener('click', () => {
        city.style.fill = '#a9a9a9';
        // Link:
        // window.location.href = 'https://kk.rks-gov.net/' + text.innerHTML.trim().toLowerCase();


        //alert
        alert(text.innerHTML.trim());
    });

    /* ----------------------------------------------------------- */
    /*  phone event listeners
    /* ----------------------------------------------------------- */
    city.addEventListener('touchstart', () => {
        city.style.fill = '#232b2b';
    });
    city.addEventListener('touchend', () => {
        city.style.fill = '#a9a9a9';
    });

})