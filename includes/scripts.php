<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GeolocationFormAutofillScripts {
    public function __construct() {
        if (get_option('geolocation_form_autofill_enable') && get_option('geolocation_form_autofill_location') === 'header') {
            add_action('wp_head', array($this, 'add_geolocation_script'));
        }

        add_shortcode('geolocation_form_autofill', array($this, 'shortcode_geolocation_script'));
    }

    // JavaScript-Code in Header 
    public function add_geolocation_script() {
        echo $this->generate_geolocation_script();
    }

    // Shortcode 
    public function shortcode_geolocation_script() {
        return $this->generate_geolocation_script();
    }

    // Generate Geolocation-Scripts
    private function generate_geolocation_script() {
        ob_start();
        ?>
        <script>
            document.addEventListener("d365mkt-afterformload", function() {
                var cityField = document.querySelector("input[name='address1_city']");
                var zipField = document.querySelector("input[name='address1_postalcode']");

                if ("geolocation" in navigator && (cityField || zipField)) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;
                        var geolocationApiUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`;

                        fetch(geolocationApiUrl)
                            .then(response => response.json())
                            .then(data => {
                                var city = data.address.city;
                                var zip = data.address.postcode;
                                console.log("Stadt: " + city);
                                console.log("PLZ: " + zip);

                                if (cityField) cityField.value = city;
                                if (zipField) zipField.value = zip;
                            })
                            .catch(error => {
                                console.error("Fehler bei der Geolokalisierung: " + error);
                            });
                    });
                } else {
                    console.log("Geolocation oder erforderliches Feld (city oder zip) ist nicht verfügbar.");
                }
            });
        </script>
        <?php
        return ob_get_clean();
    }
}

// Init Script
new GeolocationFormAutofillScripts();
?>
