# MQTT-Dashboard
MQTT Dashboard with custom metrics and charts built using PHP, Laravel and JQuery.
It gets data from actual IoT devices which can be Arduinos or Rasperry Pis and displays the metrics in realtime. It also has an option to customize widgets and the date to be shown for each device and the ability to set alerts for when specific conditions are met. Data can be exported as JPG/CSV/PDF at any time. All what a devcie has to do is publish the value to the selected MQTT topic as described when creating a device.

# RUN
composer install

php artisan migrate

php artisan key:generate

php artisan backpack:install

php artisan serve
