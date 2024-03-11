<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('css/palette.css') }}">
</head>

<body>
<div class="container">
    <h1 class="display-1"><strong>Choose</strong> a Pre-made Palette</h1>
    <div class="palette-container">
        <?php
        $colors = array(
            array('--color-1', '--color-0', '--color-2'),
            array('--color-3', '--color-0', '--color-4'),
            array('--color-5', '--color-0', '--color-6'),
            array('--color-7', '--color-0', '--color-8'),
            array('--color-9', '--color-0', '--color-10'),
            array('--color-11', '--color-0', '--color-12'),
            array('--color-13', '--color-0', '--color-14'),
            array('--color-15', '--color-0', '--color-16'),
            array('--color-17', '--color-0', '--color-18'),
            array('--color-19', '--color-0', '--color-20'),
            array('--color-21', '--color-0', '--color-22'),
            array('--color-23', '--color-0', '--color-24'),
            array('--color-25', '--color-0', '--color-26'),
            array('--color-27', '--color-0', '--color-28'),
            array('--color-29', '--color-0', '--color-30'),
            array('--color-31', '--color-0', '--color-32'),
            array('--color-33', '--color-0', '--color-34'),
            array('--color-35', '--color-0', '--color-36'),
            array('--color-37', '--color-0', '--color-38'),
            array('--color-39', '--color-0', '--color-40')
        );
        ?>

        <?php foreach ($colors as $palette): ?>
        <div class="palette">
            <div class="left-color" style="background: var(<?php echo $palette[0]; ?>);"></div>
            <div class="middle-color" style="background: var(<?php echo $palette[1]; ?>);"></div>
            <div class="right-color" style="background: var(<?php echo $palette[2]; ?>);"></div>
        </div>
        <?php endforeach; ?>





        {{--<div class="palette">
            <div class="left-color" style="background: var(--color-1);"></div>
            <div class="middle-color" style="background: var(--color-0);"></div>
            <div class="right-color" style="background: var(--color-2);"></div>
        </div>
        <div class="palette">
            <div class="left-color" style="background: var(--color-3);"></div>
            <div class="middle-color" style="background: var(--color-0);"></div>
            <div class="right-color" style="background: var(--color-4);"></div>
        </div>
        <div class="palette">
            <div class="left-color" style="background: var(--color-5);"></div>
            <div class="middle-color" style="background: var(--color-0);"></div>
            <div class="right-color" style="background: var(--color-6);"></div>
        </div>--}}






    </div>
</div>
</body>
</html>
