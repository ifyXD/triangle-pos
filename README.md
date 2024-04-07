[//]: # (<picture>)

[//]: # (    <source srcset="public/images/logo.png"  )

[//]: # (            media="&#40;prefers-color-scheme: dark&#41;">)

[//]: # (    <img src="public/images/logo-dark.png" alt="App Logo">)

[//]: # (</picture>)

> **Important Note:** This Project is ready for Production. But use code from main branch only. If you find any bug or have any suggestion please create an Issue.

# Local Installation

- run `` git clone https://github.com/FahimAnzamDip/triangle-pos.git ``
- run ``composer install `` 
- run `` npm install ``
- run ``npm run dev``
- copy .env.example to .env
- run `` php artisan key:generate ``
- set up your database in the .env
- run `` php artisan migrate --seed ``
- run `` php artisan storage:link ``
- run `` php artisan serve ``
- then visit `` http://localhost:8000 or http://127.0.0.1:8000 ``.
