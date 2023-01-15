<?php

/**
 * Plugin Name:  Car Builder
 * Plugin URI:   https://github.com/Great0s/Car_builder
 * Description:  Fasthosts Assistant will help you complete the first setup of your WordPress in quick and easy steps. It will help you find a theme to start with and add some plugins that will help you with the purpose of your WordPress installation.
 * Version:      1.0
 * License:      GPL-2.0-or-later
 * Author:       GreatOS
 * Author URI:   https://github.com/Great0s/
 */

/*
Copyright 2020 Fasthosts by 1&1
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Online: http://www.gnu.org/licenses/gpl.txt
*/

$cars_file = fopen("data.csv", "r");
$cars_data = fgetcsv($cars_file, 1000, ",");

if (($cars_file = fopen("data.csv", "r")) !== FALSE) {
    while (($cars_data = fgetcsv($cars_file, 1000, ",")) !== FALSE) {
        $array[] = $cars_data;
    }
    fclose($cars_file);
}

$brands = array();
for ($s = 1; $s <= count($array) - 1; $s++) {
    if (!in_array($array[$s][1], $brands) && isset($array[$s][1])) {
        array_push($brands, $array[$s][1]);
    }
}

?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>Car Builder</title>

    <style>
        <?php include 'assets/css/bootstrap.min.css'; ?><?php include 'assets/css/style.css'; ?>
    </style>
    <script>
        <?php include 'assets/js/bootstrap.bundle.min.js'; ?>
    </script>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="list-groups.css" rel="stylesheet">
</head>

<body>

    <!-- 
    <div class="list-group w-auto">
        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
            <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
            <div class="d-flex gap-2 w-100 justify-content-between">
                <div>
                    <h6 class="mb-0">List group item heading</h6>
                    <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
                </div>
                <small class="opacity-50 text-nowrap">now</small>
            </div>
        </a>
        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
            <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
            <div class="d-flex gap-2 w-100 justify-content-between">
                <div>
                    <h6 class="mb-0">Another title here</h6>
                    <p class="mb-0 opacity-75">Some placeholder content in a paragraph that goes a little longer so it wraps to a new line.</p>
                </div>
                <small class="opacity-50 text-nowrap">3d</small>
            </div>
        </a>
        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
            <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
            <div class="d-flex gap-2 w-100 justify-content-between">
                <div>
                    <h6 class="mb-0">Third heading</h6>
                    <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
                </div>
                <small class="opacity-50 text-nowrap">1w</small>
            </div>
        </a>
    </div>

    <div class="b-example-divider"></div>

    <div class="d-flex gap-5 justify-content-center">
        <div class="list-group mx-0 w-auto">
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="">
                <span>
                    First checkbox
                    <small class="d-block text-muted">With support text underneath to add more detail</small>
                </span>
            </label>
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" value="">
                <span>
                    Second checkbox
                    <small class="d-block text-muted">Some other text goes here</small>
                </span>
            </label>
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" value="">
                <span>
                    Third checkbox
                    <small class="d-block text-muted">And we end with another snippet of text</small>
                </span>
            </label>
        </div>

        <div class="list-group mx-0 w-auto">
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="" checked="">
                <span>
                    First radio
                    <small class="d-block text-muted">With support text underneath to add more detail</small>
                </span>
            </label>
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios2" value="">
                <span>
                    Second radio
                    <small class="d-block text-muted">Some other text goes here</small>
                </span>
            </label>
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios3" value="">
                <span>
                    Third radio
                    <small class="d-block text-muted">And we end with another snippet of text</small>
                </span>
            </label>
        </div>
    </div>

    <div class="b-example-divider"></div>

    <div class="list-group w-auto">
        <label class="list-group-item d-flex gap-3">
            <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="" style="font-size: 1.375em;">
            <span class="pt-1 form-checked-content">
                <strong>Finish sales report</strong>
                <small class="d-block text-muted">
                    <svg class="bi me-1" width="1em" height="1em">
                        <use xlink:href="#calendar-event"></use>
                    </svg>
                    1:00–2:00pm
                </small>
            </span>
        </label>
        <label class="list-group-item d-flex gap-3">
            <input class="form-check-input flex-shrink-0" type="checkbox" value="" style="font-size: 1.375em;">
            <span class="pt-1 form-checked-content">
                <strong>Weekly All Hands</strong>
                <small class="d-block text-muted">
                    <svg class="bi me-1" width="1em" height="1em">
                        <use xlink:href="#calendar-event"></use>
                    </svg>
                    2:00–2:30pm
                </small>
            </span>
        </label>
        <label class="list-group-item d-flex gap-3">
            <input class="form-check-input flex-shrink-0" type="checkbox" value="" style="font-size: 1.375em;">
            <span class="pt-1 form-checked-content">
                <strong>Out of office</strong>
                <small class="d-block text-muted">
                    <svg class="bi me-1" width="1em" height="1em">
                        <use xlink:href="#alarm"></use>
                    </svg>
                    Tomorrow
                </small>
            </span>
        </label>
        <label class="list-group-item d-flex gap-3 bg-light">
            <input class="form-check-input form-check-input-placeholder bg-light flex-shrink-0 pe-none" disabled="" type="checkbox" value="" style="font-size: 1.375em;">
            <span class="pt-1 form-checked-content">
                <span contenteditable="true" class="w-100">Add new task...</span>
                <small class="d-block text-muted">
                    <svg class="bi me-1" width="1em" height="1em">
                        <use xlink:href="#list-check"></use>
                    </svg>
                    Choose list...
                </small>
            </span>
        </label>
    </div>

    <div class="b-example-divider"></div> -->

    <div class="list-group list-group-checkable d-grid gap-2 border-0 w-auto">
        <?php
        for ($s = 0; $s <= count($brands) - 1; $s++) {
            echo '<input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios' . $s . '" value="' . $brands[$s] . '" checked="">
        <label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $s . '">
            ' . $brands[$s] . '
        </label>';
        }
        ?>
    </div>

    <div class="b-example-divider"></div>

    <!-- <div class="list-group list-group-radio d-grid gap-2 border-0 w-auto">
        <div class="position-relative">
            <input class="form-check-input position-absolute top-50 end-0 me-3 fs-5" type="radio" name="listGroupRadioGrid" id="listGroupRadioGrid1" value="" checked="">
            <label class="list-group-item py-3 pe-5" for="listGroupRadioGrid1">
                <strong class="fw-semibold">First radio</strong>
                <span class="d-block small opacity-75">With support text underneath to add more detail</span>
            </label>
        </div>

        <div class="position-relative">
            <input class="form-check-input position-absolute top-50 end-0 me-3 fs-5" type="radio" name="listGroupRadioGrid" id="listGroupRadioGrid2" value="">
            <label class="list-group-item py-3 pe-5" for="listGroupRadioGrid2">
                <strong class="fw-semibold">Second radio</strong>
                <span class="d-block small opacity-75">Some other text goes here</span>
            </label>
        </div>

        <div class="position-relative">
            <input class="form-check-input position-absolute top-50 end-0 me-3 fs-5" type="radio" name="listGroupRadioGrid" id="listGroupRadioGrid3" value="">
            <label class="list-group-item py-3 pe-5" for="listGroupRadioGrid3">
                <strong class="fw-semibold">Third radio</strong>
                <span class="d-block small opacity-75">And we end with another snippet of text</span>
            </label>
        </div>

        <div class="position-relative">
            <input class="form-check-input position-absolute top-50 end-0 me-3 fs-5" type="radio" name="listGroupRadioGrid" id="listGroupRadioGrid4" value="" disabled="">
            <label class="list-group-item py-3 pe-5" for="listGroupRadioGrid4">
                <strong class="fw-semibold">Fourth disabled radio</strong>
                <span class="d-block small opacity-75">This option is disabled</span>
            </label>
        </div>
    </div> -->

</body>

</html>

<?php


?>