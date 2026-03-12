@echo off
echo Starting local WordPress Playground server...
echo ---------------------------------------------
echo The server will mount your theme and plugin automatically.
echo Once it starts, it will give you a local URL (like http://127.0.0.1:9400).
echo Open that URL in your browser to see your WordPress site.
echo You can log into the admin panel at /wp-admin.
echo ---------------------------------------------
echo.

call npx -y @wp-playground/cli server --port 9400 --blueprint "%~dp0blueprint.json" --mount-dir "%~dp0theme\akela-mann" "/wordpress/wp-content/themes/akela-mann" --mount-dir "%~dp0plugin" "/wordpress/wp-content/plugins/akela-mann-plugin"

pause
