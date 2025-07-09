# Pre-Requisites
- Laragon (If on Windows will install the rest)
- Laravel
- Composer
- PHP
- NodeJS
- Python

# How to Install

1. Click the Big Green Button Called ```Code```
2. Copy the Link Given
3. In a terminal (VSCODE/CMD/Powershell/kitty/etc.) run (without <>):
    ```bash
    git clone <THE LINK YOU JUST COPIED>
    ```
4. Go to the directory (The place you ran the prompt from) and open VSCODE there
5. In the terminal run:
    ```bash
    composer install
    ```
6. Then run:
    ```bash
    npm install && npm run build
    ```
7. Run:
    ```bash
    php artisan migrate
    ```
8. Last but not least run:
    ```bash
    php artisan db:seed
    ```

# How to run
1. In the terminal run:
    ```bash
    composer run dev
    ```
2. enjoy :D

# Creds: 
- email: admin.example.com
- pass: admin